<?php
include 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$crime_desc = trim($_POST['crime_desc'] ?? '');
$category   = trim($_POST['category'] ?? '');

if (empty($crime_desc)) {
    header('Location: index.php');
    exit;
}

// ═══════════════════════════════════════════════════════
// CONFIG — paste your Gemini API key here
// ═══════════════════════════════════════════════════════
define('GEMINI_API_KEY', 'AIzaSyAs7YDFBaVMISfwQxe7gNFkAZ3Yd__HN74');

// ═══════════════════════════════════════════════════════
// AUTO-TRANSLATE TO ENGLISH
// ═══════════════════════════════════════════════════════
function translateToEnglish($text) {
    $url = 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=en&dt=t&q=' . urlencode($text);
    $context = stream_context_create([
        'http' => ['timeout' => 5, 'header' => 'User-Agent: Mozilla/5.0']
    ]);
    $response = @file_get_contents($url, false, $context);
    if ($response === false) return $text;
    $data = json_decode($response, true);
    if (isset($data[0]) && is_array($data[0])) {
        $translated = '';
        foreach ($data[0] as $chunk) {
            if (isset($chunk[0])) $translated .= $chunk[0];
        }
        return trim($translated) ?: $text;
    }
    return $text;
}

// ═══════════════════════════════════════════════════════
// HELPER — call Gemini API with any prompt
// ═══════════════════════════════════════════════════════
function callGemini($prompt, $maxTokens = 256) {
    $payload = json_encode([
        'contents' => [
            ['parts' => [['text' => $prompt]]]
        ],
        'generationConfig' => [
            'temperature'     => 0.0,
            'maxOutputTokens' => $maxTokens,
        ]
    ]);

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . GEMINI_API_KEY;

    $context = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/json\r\nContent-Length: " . strlen($payload),
            'content' => $payload,
            'timeout' => 15,
        ]
    ]);

    $response = @file_get_contents($url, false, $context);
    if ($response === false) return null;

    $data     = json_decode($response, true);
    $raw_text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

    // Strip markdown fences
    $raw_text = preg_replace('/^```(?:json)?\s*/i', '', trim($raw_text));
    $raw_text = preg_replace('/```\s*$/', '',  $raw_text);

    return trim($raw_text);
}

// ═══════════════════════════════════════════════════════
// STEP 1 — KEYWORD EXTRACTION
// Ask Gemini to extract only the core crime keywords
// from the user's input in any language
// ═══════════════════════════════════════════════════════
function extractKeywords($user_input) {
    $prompt = <<<PROMPT
You are a crime keyword extractor. The user has described a crime or legal situation in any language (English, Hindi, Marathi, Tamil, etc.).

Your ONLY job is to extract the core crime action keywords from the input — the words that describe WHAT happened.

RULES:
- Extract only the crime action words — not filler words like "my", "the", "is", "was", "has", "been", "I", "someone", "mera", "meri", "hai", "ho", "gaya", "hua"
- Keep Indian language crime words AS-IS — do NOT translate them, just extract them
- Return keywords as a simple comma-separated list
- Maximum 5 keywords

SUPPORTED LANGUAGES: English, Hindi, Marathi — understand all three fully.

CRIME WORDS DICTIONARY (English | Hindi | Marathi):
THEFT       → stolen, theft | chori, churaya, loot, dakaiti | chorni, choree, daroday
FRAUD       → fraud, cheat, scam, deceive | thaagi, thagi, dhoka, dhokha | fसवणूक, फसवणूक, phsavnuk, fasavnuk, dhoka
ASSAULT     → assault, beat, hit, hurt, slap | maar, maara, marpeet, peet, thappad | marpeet, thappad, maar, ghav
MURDER      → murder, kill, death | hatya, khoon, qatl | hatya, khoon, jiv ghene
RAPE        → rape, sexual force | balatkar, jabardasti | balatkar, laingikshoshan, lyngik shorshan  
EXTORTION   → blackmail, extort, threaten | dhamki, dara, blackmail | dhamki, khanda, bhiti
DOWRY       → dowry, dowry death | dahej, dahej hatya | hunda, hundyasathi tras
CRUELTY     → cruelty, domestic violence | zulm, pratarana | chan, chaan, chatrapati
CYBERCRIME  → hack, cyber, phishing, online fraud | online thagi, account hack | online phsavnuk, hack
BREACH TRUST→ breach of trust, misuse | vishwasghat, embezzle | vishwasghat, bharosha todne

EXAMPLES:
  English:  "my phone is stolen"        → stolen, theft, phone
  Hindi:    "mera phone chori ho gaya"   → chori, theft, phone
  Hindi:    "chori"                      → chori, theft
  Marathi:  "majha phone chorla"         → chorla, chori, theft
  Marathi:  "chorni zali"                → chorni, chori, theft
  Hindi:    "mujhe maara"                → maar, assault
  Marathi:  "mala marale"                → marale, maar, assault
  Hindi:    "paise ki thaagi"            → thaagi, fraud
  Marathi:  "paisyachi fasavnuk"         → fasavnuk, fraud
  Hindi:    "dhamki de raha hai"         → dhamki, threat, extortion
  Marathi:  "dhamki dili"                → dhamki, threat, extortion
  Hindi:    "dahej ke liye maar"         → dahej, dowry, cruelty
  Marathi:  "hundyasathi tras"           → hunda, dowry, cruelty

USER INPUT: "{$user_input}"

Return ONLY the comma-separated keywords. Nothing else. No explanation. No punctuation other than commas.
PROMPT;

    $result = callGemini($prompt, 64);
    if (!$result) return [];

    // Parse comma-separated keywords into array
    $keywords = array_map('trim', explode(',', strtolower($result)));
    $keywords = array_filter($keywords, fn($k) => strlen($k) > 1);
    return array_values(array_unique($keywords));
}

// ═══════════════════════════════════════════════════════
// STEP 2 — LAW MATCHING
// Pass extracted keywords to Gemini to find correct laws
// ═══════════════════════════════════════════════════════
function matchLaws($keywords, $category_filter) {
    $keywords_str = implode(', ', $keywords);

    $category_instruction = '';
    if (!empty($category_filter)) {
        $category_instruction = "IMPORTANT: Only return laws from the category: \"{$category_filter}\".\n\n";
    }

    $prompt = <<<PROMPT
You are a precise Indian legal classifier. You will receive crime keywords extracted from a user's complaint.

Your job is to identify the EXACT Indian Penal Code (IPC) or IT Act sections that match these keywords — and return full law details.

CRIME KEYWORDS: {$keywords_str}

{$category_instruction}STRICT MATCHING TABLE — match ANY of these keywords (English | Hindi | Marathi) to the section:
- stolen, theft, rob, pickpocket | chori, churai, loot, dakaiti, churaya | chorni, choree, chorla, daroday → IPC 378, IPC 379
- fraud, cheat, scam, deceive, trick | thaagi, thagi, dhoka, dhokha | fasavnuk, phsavnuk, fसवणूक → IPC 420
- blackmail, extort, threaten, ransom, demand | dhamki, dara, blackmail | dhamki, khanda, bhiti → IPC 383
- breach, trust, misuse, embezzle | vishwasghat | vishwasghat, bharosha todne → IPC 406
- assault, beat, hit, hurt, slap | maar, maara, marpeet, peet, thappad, ghayel | maar, marpeet, thappad, ghav, marale → IPC 323, IPC 352
- murder, kill, death | hatya, khoon, qatl, jaan lena | hatya, khoon, jiv ghene → IPC 302
- attempt murder, poison, shoot | hatya ka prayas | hatya prayas → IPC 307
- rape, sexual force, sexual assault | balatkar, jabardasti | balatkar, laingikshoshan → IPC 376
- molest, modesty, outrage, grope | chherna, chhed, buri nazar | chhernchhan, vikrut sparsh → IPC 354
- insult woman, eve tease, gesture | awaaz, siti, comment | siti, aavaz, tika tippani → IPC 509
- dowry death, dowry burn | dahej hatya, dahej maut | hunda hatya, hundyamule mrityu → IPC 304B
- cruelty, domestic violence, torture | dahej, zulm, pratarana, maar peet | hunda, hundyasathi tras, chan → IPC 498A
- hack, cyber, phishing, online fraud, account | online thagi, password chori | online phsavnuk, khate hack → IT Act 66
- obscene, porn, video, photo | asheel, ashlil | ashlil chitra, ashil video → IT Act 67

RULES:
1. Match keywords to sections using the table above ONLY
2. Return ONLY sections whose keywords appear in the input keywords list
3. Maximum 2 sections
4. Do NOT add sections whose keywords are NOT in the input
5. If no keywords match → return empty laws array

Return ONLY this exact JSON (no markdown, no code fences, no extra text):
{
  "laws": [
    {
      "category": "Theft",
      "section": "378",
      "title": "Theft",
      "description": "Whoever, intending to take dishonestly any movable property out of the possession of any person without that person's consent, moves that property in order to take it.",
      "punishment": "Imprisonment up to 3 years, or fine, or both."
    }
  ],
  "ai_answer": "Plain English explanation of what laws apply and what the user should do. Be practical and empathetic. 3-5 sentences max.",
  "severity": "low|medium|high|critical",
  "recommended_action": "A single short action the user should take immediately."
}
PROMPT;

    $raw = callGemini($prompt, 1024);
    if (!$raw) return null;

    $parsed = json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE) return null;

    return $parsed;
}

// ═══════════════════════════════════════════════════════
// MAIN FLOW
// ═══════════════════════════════════════════════════════
$crime_desc_original = $crime_desc;
$crime_desc_english  = translateToEnglish($crime_desc);

$ai_answer          = null;
$severity           = null;
$recommended_action = null;
$extracted_keywords = [];

// Step 1 — Extract keywords from user input
$extracted_keywords = extractKeywords($crime_desc_english);

// Step 2 — Match laws using extracted keywords
$gemini_result = null;
if (!empty($extracted_keywords)) {
    $gemini_result = matchLaws($extracted_keywords, $category);
}

if ($gemini_result !== null) {
    // Gemini succeeded — use its law data directly
    $results            = $gemini_result['laws']               ?? [];
    $ai_answer          = $gemini_result['ai_answer']          ?? null;
    $severity           = $gemini_result['severity']           ?? 'medium';
    $recommended_action = $gemini_result['recommended_action'] ?? null;

} else {
    // Gemini failed — fall back to keyword DB search
    $words        = preg_split('/\s+/', strtolower($crime_desc_english));
    $search_terms = [];

    foreach ($words as $w) {
        $w = trim($w);
        if (strlen($w) > 2) {
            $search_terms[] = $w;
            if (str_ends_with($w, 'ed'))  $search_terms[] = substr($w, 0, -2);
            if (str_ends_with($w, 'ing')) $search_terms[] = substr($w, 0, -3);
            if (str_ends_with($w, 's'))   $search_terms[] = substr($w, 0, -1);
        }
    }
    $search_terms = array_unique($search_terms);

    $sql    = "SELECT * FROM laws WHERE 1=1";
    $params = [];

    if (!empty($category)) {
        $sql     .= " AND category = ?";
        $params[] = $category;
    }

    $conditions = [];
    foreach ($search_terms as $term) {
        $like         = '%' . $term . '%';
        $conditions[] = "LOWER(keywords) LIKE ?";
        $conditions[] = "LOWER(title) LIKE ?";
        $conditions[] = "LOWER(description) LIKE ?";
        $params[]     = $like;
        $params[]     = $like;
        $params[]     = $like;
    }

    if (!empty($conditions)) {
        $sql .= " AND (" . implode(" OR ", $conditions) . ")";
    }

    $sql .= " ORDER BY id LIMIT 8";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Restore original description for display
$crime_desc = $crime_desc_original;

include 'result.php';
?>