<?php
$conn = new mysqli("localhost", "root", "", "smart_legal");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$result = $conn->query("SELECT * FROM laws ORDER BY id ASC");
$dbRows = [];
while ($row = $result->fetch_assoc()) {
    $dbRows[] = $row;
}
$conn->close();

function getCatStyle($category) {
    $map = [
        'Theft'                  => ['🛍️', 'rgba(16,185,129,.1)',   '#6ee7b7'],
        'Extortion'              => ['💰', 'rgba(251,191,36,.1)',   '#fde68a'],
        'Cheating'               => ['💸', 'rgba(251,191,36,.1)',   '#fde68a'],
        'Criminal Breach of Trust'=> ['🤝','rgba(251,191,36,.1)',   '#fde68a'],
        'Assault'                => ['🤛', 'rgba(251,191,36,.1)',   '#fde68a'],
        'Hurt'                   => ['🤕', 'rgba(251,191,36,.1)',   '#fde68a'],
        'Murder'                 => ['🔪', 'rgba(239,68,68,.15)',   '#fca5a5'],
        'Attempt to Murder'      => ['⚔️', 'rgba(239,68,68,.15)',   '#fca5a5'],
        'Rape'                   => ['⚠️', 'rgba(239,68,68,.15)',   '#fca5a5'],
        'Cybercrime'             => ['💻', 'rgba(59,130,246,.12)',  '#93c5fd'],
        'Robbery'                => ['🚗', 'rgba(251,191,36,.1)',   '#fde68a'],
        'Dacoity'                => ['🔫', 'rgba(239,68,68,.15)',   '#fca5a5'],
        'Arson'                  => ['🔥', 'rgba(239,68,68,.15)',   '#fca5a5'],
        'Defamation'             => ['🤥', 'rgba(16,185,129,.1)',   '#6ee7b7'],
        'Trespass'               => ['🏠', 'rgba(16,185,129,.1)',   '#6ee7b7'],
        'Bribery'                => ['👮', 'rgba(251,191,36,.1)',   '#fde68a'],
        'Kidnapping'             => ['🚨', 'rgba(239,68,68,.15)',   '#fca5a5'],
        'Culpable Homicide'      => ['💊', 'rgba(239,68,68,.15)',   '#fca5a5'],
        'Forgery'                => ['📄', 'rgba(251,191,36,.1)',   '#fde68a'],
        'Counterfeiting'         => ['💵', 'rgba(251,191,36,.1)',   '#fde68a'],
        'Public Nuisance'        => ['📢', 'rgba(16,185,129,.1)',   '#6ee7b7'],
    ];
    $cat = trim($category);
    foreach ($map as $key => $val) {
        if (stripos($cat, $key) !== false) return $val;
    }
    return ['⚖️', 'rgba(201,168,76,.12)', '#c9a84c'];
}

function getSeverity($category, $punishment) {
    $high = ['Murder','Attempt to Murder','Rape','Dacoity','Arson','Kidnapping','Culpable Homicide'];
    $low  = ['Theft','Defamation','Trespass','Assault','Hurt','Public Nuisance'];
    foreach ($high as $h) { if (stripos($category, $h) !== false) return 'high'; }
    foreach ($low  as $l) { if (stripos($category, $l) !== false) return 'low';  }
    return 'med';
}

function isBailable($punishment) {
    $p = strtolower($punishment);
    if (strpos($p, 'death') !== false) return false;
    if (strpos($p, 'life')  !== false) return false;
    if (preg_match('/(\d+)\s*year/', $p, $m) && intval($m[1]) >= 3) return false;
    return true;
}

function isCognizable($category) {
    $nonCog = ['Assault','Defamation','Trespass','Hurt','Public Nuisance'];
    foreach ($nonCog as $nc) { if (stripos($category, $nc) !== false) return false; }
    return true;
}

function keywordsToJsTags($keywords) {
    $tags = array_map('trim', explode(',', $keywords));
    $tags = array_filter($tags);
    $tags = array_map(function($t){ return addslashes(ucwords($t)); }, $tags);
    return '["' . implode('","', $tags) . '"]';
}

function getSteps($category) {
    $cat = strtolower($category);
    if (strpos($cat,'cyber') !== false)
        return ['Preserve digital evidence (screenshots)','File at cybercrime.gov.in','Call 1930 (Cybercrime Helpline)','Do not delete any messages'];
    if (strpos($cat,'theft') !== false || strpos($cat,'robbery') !== false)
        return ['File FIR with item details','Provide CCTV footage if available','List all stolen items','Get acknowledgment receipt'];
    if (strpos($cat,'murder') !== false || strpos($cat,'homicide') !== false)
        return ['Report to nearest police station immediately','Post-mortem report is mandatory','Preserve all evidence at scene','File FIR immediately'];
    if (strpos($cat,'assault') !== false || strpos($cat,'hurt') !== false)
        return ['Seek medical attention first','Get a medical injury report (MLC)','File FIR with details','Preserve clothing as evidence'];
    if (strpos($cat,'cheat') !== false || strpos($cat,'fraud') !== false || strpos($cat,'extortion') !== false)
        return ['Save all communication proof','File FIR citing the relevant section','Contact bank to freeze transactions','Report to cybercrime if online'];
    if (strpos($cat,'bribery') !== false || strpos($cat,'corruption') !== false)
        return ['Report to Anti-Corruption Bureau (ACB)','Call 1064 (ACB Helpline)','Arrange a trap with ACB','Do not pay unless directed by ACB'];
    return ['File FIR at nearest police station','Gather all available evidence','Record witness statements','Consult a legal advocate'];
}

function getExample($category) {
    $cat = strtolower($category);
    if (strpos($cat,'theft')     !== false) return 'Pickpocketing a wallet or stealing a mobile phone from a shop.';
    if (strpos($cat,'extortion') !== false) return 'Threatening to release private photos unless money is paid.';
    if (strpos($cat,'cheat')     !== false) return 'Fake investment scheme promising returns, or UPI fraud.';
    if (strpos($cat,'assault')   !== false) return 'Punching someone causing injury, or attacking with a weapon.';
    if (strpos($cat,'hurt')      !== false) return 'Striking someone during an argument causing bodily injury.';
    if (strpos($cat,'murder')    !== false) return 'A person shoots or stabs another with intent to kill.';
    if (strpos($cat,'rape')      !== false) return 'Non-consensual sexual act committed by force or threat.';
    if (strpos($cat,'cyber')     !== false) return 'Hacking bank account, phishing email, or online identity theft.';
    if (strpos($cat,'robbery')   !== false) return 'Snatching a chain at knifepoint or an armed home break-in.';
    if (strpos($cat,'arson')     !== false) return 'Setting fire to a crop field or house out of vendetta.';
    if (strpos($cat,'trespass')  !== false) return 'Landlord entering rented premises without consent.';
    if (strpos($cat,'defam')     !== false) return 'Spreading false rumours online to damage someone\'s career.';
    if (strpos($cat,'bribery')   !== false) return 'Police officer demanding money to register an FIR.';
    if (strpos($cat,'trust')     !== false) return 'Employee misappropriating funds entrusted by the employer.';
    if (strpos($cat,'kidnap')    !== false) return 'Abducting a person for ransom or against their will.';
    if (strpos($cat,'nuisance')  !== false) return 'Person causing smoke or noise nuisance to the neighbourhood.';
    return 'An offence committed in violation of the Indian Penal Code.';
}

// ── Fine map keyed by IPC section number ─────────────────────────────────────
function getFineBySection($section) {
    $fineMap = [
        // Theft
        '378'=>'₹1,000 – ₹5,000',  '379'=>'₹1,000 – ₹5,000',
        '380'=>'₹5,000 – ₹10,000', '381'=>'₹5,000 – ₹10,000',
        '382'=>'₹10,000 – ₹25,000',
        // Extortion & Robbery
        '383'=>'₹2,000 – ₹10,000', '384'=>'₹2,000 – ₹10,000',
        '385'=>'₹1,000 – ₹5,000',  '386'=>'₹5,000 – ₹20,000',
        '387'=>'₹5,000 – ₹20,000', '388'=>'₹5,000 – ₹20,000',
        '389'=>'₹5,000 – ₹20,000',
        '390'=>'₹10,000 – ₹50,000','391'=>'₹10,000 – ₹50,000',
        '392'=>'₹10,000 – ₹50,000','393'=>'₹5,000 – ₹20,000',
        '394'=>'₹10,000 – ₹50,000','395'=>'₹25,000 – ₹1,00,000',
        '396'=>'No fixed fine limit',
        // Cheating & Fraud
        '415'=>'₹5,000 – ₹25,000', '416'=>'₹5,000 – ₹25,000',
        '417'=>'₹1,000 – ₹5,000',  '418'=>'₹2,000 – ₹10,000',
        '419'=>'₹2,000 – ₹10,000', '420'=>'₹5,000 – ₹50,000',
        // Criminal Breach of Trust
        '405'=>'₹5,000 – ₹25,000', '406'=>'₹5,000 – ₹25,000',
        '407'=>'₹10,000 – ₹50,000','408'=>'₹10,000 – ₹50,000',
        '409'=>'₹10,000 – ₹50,000',
        // Assault & Hurt
        '319'=>'₹500 – ₹1,000',    '320'=>'₹1,000 – ₹5,000',
        '321'=>'₹500 – ₹1,000',    '322'=>'₹1,000 – ₹5,000',
        '323'=>'Up to ₹1,000',     '324'=>'₹2,000 – ₹5,000',
        '325'=>'₹5,000 – ₹10,000', '326'=>'₹10,000 – ₹25,000',
        '352'=>'Up to ₹500',       '355'=>'Up to ₹500',
        // Murder & Homicide
        '299'=>'No fixed fine limit','300'=>'No fixed fine limit',
        '302'=>'No fixed fine limit','303'=>'No fixed fine limit',
        '304'=>'₹10,000 – ₹50,000', '304A'=>'₹5,000 – ₹10,000',
        '304B'=>'No fixed fine limit','305'=>'No fixed fine limit',
        '306'=>'₹10,000 – ₹25,000', '307'=>'₹10,000 – ₹25,000',
        '308'=>'₹5,000 – ₹10,000',
        // Rape
        '375'=>'No fixed fine limit','376'=>'No fixed fine limit',
        '376A'=>'No fixed fine limit','376B'=>'No fixed fine limit',
        '376C'=>'No fixed fine limit','376D'=>'No fixed fine limit',
        // Trespass
        '441'=>'₹500 – ₹1,000',    '442'=>'₹500 – ₹2,000',
        '447'=>'Up to ₹500',       '448'=>'₹1,000 – ₹5,000',
        '449'=>'₹10,000 – ₹25,000','450'=>'₹10,000 – ₹25,000',
        '451'=>'₹5,000 – ₹10,000', '452'=>'₹5,000 – ₹10,000',
        // Defamation
        '499'=>'₹2,000 – ₹10,000', '500'=>'₹2,000 – ₹10,000',
        '501'=>'₹1,000 – ₹5,000',  '502'=>'₹1,000 – ₹5,000',
        // Kidnapping
        '363'=>'₹10,000 – ₹50,000','365'=>'₹10,000 – ₹25,000',
        '366'=>'No fixed fine limit','367'=>'No fixed fine limit',
        '368'=>'₹10,000 – ₹25,000',
        // Arson / Mischief
        '435'=>'₹10,000 – ₹50,000','436'=>'No fixed fine limit',
        '437'=>'₹10,000 – ₹50,000','438'=>'No fixed fine limit',
        // Forgery
        '465'=>'₹5,000 – ₹25,000', '466'=>'₹10,000 – ₹50,000',
        '467'=>'No fixed fine limit','468'=>'₹10,000 – ₹50,000',
        '469'=>'₹5,000 – ₹25,000', '471'=>'₹5,000 – ₹25,000',
        // Counterfeiting
        '489A'=>'No fixed fine limit','489B'=>'No fixed fine limit',
        '489C'=>'₹10,000 – ₹50,000','489D'=>'₹10,000 – ₹50,000',
        // Bribery
        '161'=>'₹25,000 – ₹1,00,000','162'=>'₹10,000 – ₹50,000',
        '163'=>'₹10,000 – ₹50,000',  '164'=>'₹10,000 – ₹50,000',
        '165'=>'₹10,000 – ₹50,000',
        // Cybercrime (IT Act)
        '66' =>'₹5,00,000 – ₹10,00,000',
        '67' =>'₹5,00,000 – ₹10,00,000',
        '43' =>'Up to ₹1,00,00,000',
        // Public Nuisance
        '268'=>'Up to ₹200',
        '290'=>'Up to ₹200',
        '291'=>'₹200 – ₹1,000',
    ];
    $sec = trim($section);
    return isset($fineMap[$sec]) ? $fineMap[$sec] : null;
}

$jsCategories = [];
foreach ($dbRows as $row) {
    list($icon, $iconBg, $iconColor) = getCatStyle($row['category']);
    $sev        = getSeverity($row['category'], $row['punishment']);
    $bailable   = isBailable($row['punishment']) ? 'true' : 'false';
    $cognizable = isCognizable($row['category']) ? 'true' : 'false';
    $tags       = keywordsToJsTags($row['keywords']);
    $steps      = getSteps($row['category']);
    $stepsJs    = '["' . implode('","', array_map('addslashes', $steps)) . '"]';
    $example    = addslashes(getExample($row['category']));
    $short      = addslashes(mb_substr(strip_tags($row['description']), 0, 90));
    $desc       = addslashes(strip_tags($row['description']));
    $title      = addslashes($row['title']);
    $ipc        = 'Section ' . addslashes($row['section']);

    // Fine: section map first → regex from punishment text → fallback
    $fine = getFineBySection($row['section']);
    if ($fine === null) {
        $pText = $row['punishment'];
        if (preg_match('/fine\s+(?:up\s+to\s+|of\s+)?(?:Rs\.?|₹)?\s*([\d,]+)\s*(?:rupees?|rupe?s?)?/i', $pText, $fm)) {
            $fine = '₹' . number_format((int) str_replace(',', '', $fm[1]));
        } elseif (preg_match('/([\d,]+)\s*rupees?/i', $pText, $fm)) {
            $fine = '₹' . number_format((int) str_replace(',', '', $fm[1]));
        } elseif (stripos($pText, 'fine') !== false) {
            $fine = 'As directed by Court';
        } else {
            $fine = 'No monetary fine';
        }
    }

    $jsCategories[] = '{
        id: ' . intval($row['id']) . ',
        icon: "' . $icon . '", iconBg: "' . $iconBg . '", iconColor: "' . $iconColor . '",
        title: "' . $title . '", ipc: "' . $ipc . '",
        sev: "' . $sev . '", bailable: ' . $bailable . ',
        tags: ' . $tags . ',
        short: "' . $short . '",
        desc: "' . $desc . '",
        punishment: "' . addslashes($row['punishment']) . '",
        fine: "' . addslashes($fine) . '",
        cognizable: ' . $cognizable . ',
        example: "' . $example . '",
        steps: ' . $stepsJs . '
    }';
}
$categoriesJson = 'const categories = [' . implode(",\n", $jsCategories) . '];';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Categories — Smart Legal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{--navy:#060d1f;--midnight:#0b1629;--royal:#1a3a6e;--gold:#c9a84c;--gold-light:#f0c96e;--gold-pale:rgba(201,168,76,0.12);--text:#e8e2d5;--muted:#8a8070;--glass:rgba(255,255,255,0.04);--glass-border:rgba(201,168,76,0.18)}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        html{scroll-behavior:smooth}
        body{background:var(--navy);font-family:'DM Sans',sans-serif;color:var(--text);min-height:100vh;overflow-x:hidden}
        body::before{content:'';position:fixed;inset:0;background-image:repeating-linear-gradient(0deg,transparent,transparent 60px,rgba(201,168,76,.025) 60px,rgba(201,168,76,.025) 61px),repeating-linear-gradient(90deg,transparent,transparent 60px,rgba(201,168,76,.025) 60px,rgba(201,168,76,.025) 61px);pointer-events:none;z-index:0}
        .orb{position:fixed;border-radius:50%;filter:blur(120px);pointer-events:none;z-index:0}
        .orb-1{width:600px;height:600px;background:rgba(26,58,110,.5);top:-200px;left:-200px;animation:drift 12s ease-in-out infinite}
        .orb-2{width:400px;height:400px;background:rgba(201,168,76,.08);bottom:-100px;right:-100px;animation:drift 16s ease-in-out infinite reverse}
        @keyframes drift{0%,100%{transform:translate(0,0)}50%{transform:translate(30px,20px)}}
        .navbar{background:rgba(6,13,31,.85);backdrop-filter:blur(20px);border-bottom:1px solid var(--glass-border);padding:1rem 0;position:fixed;width:100%;top:0;z-index:1000;transition:all .3s}
        .navbar.scrolled{padding:.6rem 0;background:rgba(6,13,31,.97)}
        .navbar-brand{font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;background:linear-gradient(135deg,var(--gold),var(--gold-light));-webkit-background-clip:text;-webkit-text-fill-color:transparent;letter-spacing:.5px}
        .nav-link{color:var(--text)!important;font-weight:500;font-size:.9rem;letter-spacing:.5px;text-transform:uppercase;padding:.5rem 1.2rem!important;transition:color .2s}
        .nav-link:hover,.nav-link.active{color:var(--gold)!important}
        .btn-gold{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:var(--navy);font-weight:700;font-size:.95rem;padding:14px 36px;border-radius:100px;border:none;letter-spacing:.5px;transition:all .3s;text-decoration:none;display:inline-flex;align-items:center;gap:8px}
        .btn-gold:hover{transform:translateY(-3px);box-shadow:0 15px 40px rgba(201,168,76,.35);color:var(--navy)}
        .btn-translate-page{background:transparent;border:1.5px solid var(--glass-border);color:var(--gold-light);font-size:.82rem;font-weight:600;padding:8px 16px;border-radius:100px;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .3s;letter-spacing:.3px}
        .btn-translate-page:hover{background:var(--gold-pale);border-color:var(--gold);color:var(--gold-light)}
        .page-hero{padding:130px 0 70px;position:relative;z-index:1;text-align:center}
        .page-hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 80% 60% at 50% 0%,rgba(26,58,110,.6) 0%,transparent 70%)}
        .hero-badge{display:inline-flex;align-items:center;gap:8px;background:var(--gold-pale);border:1px solid var(--glass-border);color:var(--gold-light);padding:6px 18px;border-radius:100px;font-size:.8rem;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:1.5rem;animation:fadeUp .6s ease both}
        .page-hero h1{font-family:'Playfair Display',serif;font-size:clamp(2.4rem,6vw,4rem);font-weight:900;color:white;animation:fadeUp .7s .1s ease both}
        .page-hero h1 span{background:linear-gradient(135deg,var(--gold),var(--gold-light));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .page-hero p{font-size:1.05rem;color:#a09888;max-width:580px;margin:1.2rem auto 0;animation:fadeUp .7s .2s ease both;line-height:1.8}
        .filter-bar{position:relative;z-index:2;padding:0 0 60px}
        .search-wrap{position:relative;max-width:560px;margin:0 auto}
        .search-wrap input{width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(201,168,76,.25);border-radius:50px;padding:16px 56px 16px 24px;color:var(--text);font-size:1rem;outline:none;transition:all .3s;font-family:'DM Sans',sans-serif}
        .search-wrap input::placeholder{color:var(--muted)}
        .search-wrap input:focus{border-color:var(--gold);box-shadow:0 0 0 4px rgba(201,168,76,.12);background:rgba(255,255,255,.07)}
        .search-wrap .search-icon{position:absolute;right:20px;top:50%;transform:translateY(-50%);color:var(--gold);font-size:1rem;pointer-events:none}
        .filter-pills{display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-top:1.5rem}
        .filter-pill{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.1);color:var(--muted);border-radius:100px;padding:7px 20px;font-size:.82rem;font-weight:500;cursor:pointer;transition:all .25s}
        .filter-pill:hover,.filter-pill.active{background:var(--gold-pale);border-color:var(--gold);color:var(--gold-light)}
        .section-main{position:relative;z-index:2;padding-bottom:80px}
        .results-meta{color:var(--muted);font-size:.85rem;margin-bottom:1.5rem}
        .results-meta span{color:var(--gold-light);font-weight:600}
        .cat-card{background:rgba(255,255,255,.03);border:1px solid var(--glass-border);border-radius:20px;overflow:hidden;transition:all .35s cubic-bezier(.25,.8,.25,1);cursor:pointer;position:relative;animation:fadeUp .5s ease both}
        .cat-card:hover{transform:translateY(-6px);border-color:rgba(201,168,70,.45);box-shadow:0 24px 50px rgba(0,0,0,.35)}
        .cat-card:hover .cat-arrow{opacity:1;transform:translateX(0)}
        .cat-card::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(201,168,76,.06) 0%,transparent 60%);opacity:0;transition:opacity .3s}
        .cat-card:hover::before{opacity:1}
        .cat-header{padding:1.5rem 1.5rem 1rem;display:flex;align-items:flex-start;justify-content:space-between;gap:12px}
        .cat-icon-wrap{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0}
        .cat-arrow{color:var(--gold);font-size:.85rem;opacity:0;transform:translateX(-6px);transition:all .3s;margin-top:4px}
        .cat-title{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:white;margin-bottom:4px;line-height:1.2}
        .cat-ipc{font-size:.75rem;color:var(--gold);font-weight:600;letter-spacing:.5px}
        .cat-body{padding:0 1.5rem 1rem}
        .cat-desc{color:var(--muted);font-size:.84rem;line-height:1.65;margin-bottom:1rem}
        .cat-tags{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:1rem}
        .cat-tag{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);color:var(--muted);border-radius:6px;padding:3px 10px;font-size:.72rem}
        .cat-footer{padding:1rem 1.5rem;border-top:1px solid var(--glass-border);display:flex;align-items:center;justify-content:space-between}
        .sev-badge{display:inline-flex;align-items:center;gap:5px;font-size:.74rem;font-weight:600;padding:4px 10px;border-radius:100px}
        .sev-high{background:rgba(239,68,68,.12);color:#fca5a5;border:1px solid rgba(239,68,68,.25)}
        .sev-med{background:rgba(251,191,36,.1);color:#fde68a;border:1px solid rgba(251,191,36,.2)}
        .sev-low{background:rgba(16,185,129,.1);color:#6ee7b7;border:1px solid rgba(16,185,129,.2)}
        .cat-fine{color:var(--gold-light);font-size:.78rem;font-weight:600}
        .compare-bar{position:fixed;bottom:0;left:0;right:0;z-index:500;background:rgba(11,22,41,.97);border-top:1px solid var(--glass-border);padding:12px 20px;transform:translateY(100%);transition:transform .4s cubic-bezier(.25,.8,.25,1);backdrop-filter:blur(20px)}
        .compare-bar.visible{transform:translateY(0)}
        .compare-slot{width:120px;height:44px;border-radius:12px;border:1.5px dashed rgba(201,168,76,.3);display:flex;align-items:center;justify-content:center;font-size:.75rem;color:var(--muted);transition:all .3s;flex-shrink:0;position:relative}
        .compare-slot.filled{border-style:solid;border-color:var(--gold);background:var(--gold-pale);color:var(--gold-light)}
        .compare-slot .slot-remove{position:absolute;top:-6px;right:-6px;width:16px;height:16px;border-radius:50%;background:#ef4444;color:white;font-size:.6rem;display:none;align-items:center;justify-content:center;cursor:pointer;border:none}
        .compare-slot.filled .slot-remove{display:flex}
        .btn-compare-now{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:var(--navy);border:none;border-radius:12px;padding:10px 24px;font-weight:700;font-size:.88rem;cursor:pointer;transition:all .3s;white-space:nowrap}
        .btn-compare-now:hover{opacity:.88;transform:translateY(-2px)}
        .btn-compare-now:disabled{opacity:.4;cursor:not-allowed;transform:none}
        #compareModal .modal-content{background:#0b1629;border:1px solid var(--glass-border);border-radius:24px;max-height:90vh;overflow-y:auto}
        .side-panel{position:fixed;right:-440px;top:0;height:100%;width:420px;background:var(--midnight);border-left:1px solid var(--glass-border);z-index:900;transition:right .4s cubic-bezier(.25,.8,.25,1);overflow-y:auto;padding:2rem 1.75rem}
        .side-panel.open{right:0}
        .side-panel::-webkit-scrollbar{width:4px}
        .side-panel::-webkit-scrollbar-thumb{background:rgba(201,168,76,.3);border-radius:10px}
        .panel-close{background:rgba(255,255,255,.06);border:1px solid var(--glass-border);color:var(--muted);width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;flex-shrink:0}
        .panel-close:hover{background:rgba(239,68,68,.15);color:#f87171;border-color:rgba(239,68,68,.3)}
        .panel-overlay{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:899;opacity:0;pointer-events:none;transition:opacity .3s}
        .panel-overlay.active{opacity:1;pointer-events:all}
        .panel-ipc-big{font-family:'Playfair Display',serif;font-size:3rem;font-weight:900;background:linear-gradient(135deg,var(--gold),var(--gold-light));-webkit-background-clip:text;-webkit-text-fill-color:transparent;line-height:1}
        .panel-section{margin-bottom:1.5rem}
        .panel-section-label{color:var(--gold);font-size:.72rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:.5rem;display:flex;align-items:center;gap:6px}
        .panel-section-val{color:var(--text);font-size:.9rem;line-height:1.7}
        .info-row{display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid rgba(255,255,255,.05)}
        .info-row:last-child{border-bottom:none}
        .info-label{color:var(--muted);font-size:.8rem}
        .info-val{color:var(--text);font-size:.85rem;font-weight:500;text-align:right}
        .fine-highlight{background:rgba(240,201,110,.1);border:1px solid rgba(240,201,110,.25);border-radius:10px;padding:12px 16px;color:var(--gold-light);font-size:.9rem;font-weight:600;text-align:center;margin-bottom:1rem}
        .panel-action-btn{width:100%;background:linear-gradient(135deg,var(--gold),var(--gold-light));color:var(--navy);border:none;border-radius:12px;padding:14px;font-weight:700;font-size:.95rem;cursor:pointer;transition:all .3s;margin-top:.5rem}
        .panel-action-btn:hover{opacity:.88;transform:translateY(-2px)}
        .add-compare-btn{width:100%;background:rgba(201,168,76,.1);border:1.5px solid var(--glass-border);color:var(--gold-light);border-radius:12px;padding:12px;font-weight:600;font-size:.88rem;cursor:pointer;transition:all .3s;margin-top:.5rem}
        .add-compare-btn:hover{background:rgba(201,168,76,.2);border-color:var(--gold)}
        .stats-strip{position:relative;z-index:2;border-top:1px solid var(--glass-border);border-bottom:1px solid var(--glass-border);background:rgba(255,255,255,.02);padding:2rem 0}
        .stat-num{font-family:'Playfair Display',serif;font-size:2.2rem;font-weight:700;background:linear-gradient(135deg,var(--gold),var(--gold-light));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .stat-label{color:var(--muted);font-size:.8rem;letter-spacing:1px;text-transform:uppercase;margin-top:4px}
        footer{background:var(--midnight);border-top:1px solid var(--glass-border);padding:3rem 0 2rem;position:relative;z-index:2}
        .footer-brand{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;background:linear-gradient(135deg,var(--gold),var(--gold-light));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .footer-disclaimer{background:rgba(255,255,255,.02);border:1px solid var(--glass-border);border-radius:12px;padding:12px 18px;font-size:.8rem;color:var(--muted);margin-top:1.5rem;text-align:center}
        .toast-container{position:fixed;bottom:100px;right:28px;z-index:9999;display:flex;flex-direction:column;gap:8px}
        .custom-toast{background:rgba(11,22,41,.95);border:1px solid var(--glass-border);border-radius:16px;padding:14px 20px;color:var(--text);font-size:.88rem;min-width:250px;box-shadow:0 15px 40px rgba(0,0,0,.4);animation:slideIn .3s ease}
        @keyframes slideIn{from{transform:translateX(100%);opacity:0}to{transform:translateX(0);opacity:1}}
        #translatorModal .modal-content{background:#0b1629;border:1px solid var(--glass-border);border-radius:24px}
        .trans-modal-header{background:linear-gradient(135deg,rgba(201,168,76,.15),rgba(201,168,76,.04));border-bottom:1px solid var(--glass-border);padding:1.4rem 1.75rem;display:flex;align-items:center;gap:14px}
        .trans-modal-icon{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--gold-light));display:flex;align-items:center;justify-content:center;color:var(--navy);font-size:1rem;flex-shrink:0}
        .trans-modal-body{padding:2rem 1.75rem 1rem}
        .lang-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:1.25rem}
        .lang-chip{background:rgba(255,255,255,.04);border:1.5px solid rgba(201,168,76,.18);border-radius:12px;padding:12px 8px;text-align:center;cursor:pointer;transition:all .25s;color:var(--muted);font-size:.84rem;font-weight:500}
        .lang-chip:hover{background:var(--gold-pale);color:var(--gold-light);border-color:var(--gold)}
        .lang-chip.selected{background:rgba(201,168,76,.2);border-color:var(--gold);color:var(--gold-light);box-shadow:0 0 0 3px rgba(201,168,76,.12)}
        .lang-chip .lang-flag{font-size:1.4rem;display:block;margin-bottom:4px}
        .trans-modal-footer{padding:0 1.75rem 1.75rem;display:flex;gap:10px}
        .btn-trans-confirm{flex:1;background:linear-gradient(135deg,var(--gold),var(--gold-light));color:var(--navy);border:none;border-radius:12px;padding:13px;font-weight:700;font-size:.95rem;cursor:pointer;transition:all .3s}
        .btn-trans-confirm:hover{opacity:.88;transform:translateY(-2px)}
        .btn-trans-cancel{background:rgba(255,255,255,.05);color:var(--muted);border:1px solid rgba(255,255,255,.1);border-radius:12px;padding:13px 22px;font-size:.9rem;cursor:pointer;transition:all .2s}
        .btn-trans-cancel:hover{background:rgba(255,255,255,.08);color:var(--text)}
        .trans-status{background:rgba(201,168,76,.08);border:1px solid var(--glass-border);border-radius:10px;padding:10px 14px;font-size:.84rem;color:var(--muted);margin-bottom:1rem;display:none;align-items:center;gap:10px}
        .trans-spinner{width:16px;height:16px;border:2px solid rgba(201,168,76,.3);border-top-color:var(--gold);border-radius:50%;animation:spin .8s linear infinite;flex-shrink:0}
        @keyframes spin{to{transform:rotate(360deg)}}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        ::-webkit-scrollbar{width:6px}::-webkit-scrollbar-track{background:var(--navy)}::-webkit-scrollbar-thumb{background:rgba(201,168,76,.3);border-radius:10px}
        @media(max-width:768px){.side-panel{width:100%;right:-100%}.lang-grid{grid-template-columns:repeat(2,1fr)}.compare-bar .d-flex{flex-wrap:wrap;gap:8px}}
        .no-results{text-align:center;padding:60px 20px;color:var(--muted)}
        .no-results i{font-size:3rem;color:rgba(201,168,76,.3);margin-bottom:1rem}
    </style>
</head>
<body>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<nav class="navbar navbar-expand-lg" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.php">⚖ Smart Legal</a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav" style="color:var(--gold)"><i class="fas fa-bars"></i></button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="categories.php">Categories</a></li>
                <li class="nav-item">
                    <button class="btn-translate-page" onclick="openTranslatorModal()"><i class="fas fa-globe"></i> Translate Page</button>
                </li>
                <li class="nav-item ms-2">
                    <a href="index.php#form-section" class="btn-gold" style="font-size:.82rem;padding:10px 22px"><i class="fas fa-gavel"></i> Report Now</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="page-hero">
    <div class="container position-relative" style="z-index:2">
        <div class="hero-badge"><i class="fas fa-layer-group"></i> Complete IPC Reference</div>
        <h1>Crime <span>Categories</span></h1>
        <p>Browse all major crime categories under the Indian Penal Code. Click any category to explore sections, punishments, and file a case.</p>
    </div>
</section>

<div class="stats-strip">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3"><div class="stat-num" id="sc1">0</div><div class="stat-label">Categories Listed</div></div>
            <div class="col-6 col-md-3"><div class="stat-num" id="sc2">0</div><div class="stat-label">IPC Sections Covered</div></div>
            <div class="col-6 col-md-3"><div class="stat-num" id="sc3">0</div><div class="stat-label">Bailable Offences</div></div>
            <div class="col-6 col-md-3"><div class="stat-num" id="sc4">0</div><div class="stat-label">Non-Bailable</div></div>
        </div>
    </div>
</div>

<section class="filter-bar pt-5">
    <div class="container">
        <div class="search-wrap">
            <input type="text" id="catSearch" placeholder="Search crime categories, IPC sections..." oninput="filterCards()">
            <i class="fas fa-search search-icon"></i>
        </div>
        <div class="filter-pills mt-3" id="filterPills">
            <span class="filter-pill active" onclick="setPill(this,'all')">All</span>
            <span class="filter-pill" onclick="setPill(this,'high')"><span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#fca5a5;margin-right:5px;vertical-align:middle"></span>Serious</span>
            <span class="filter-pill" onclick="setPill(this,'med')"><span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#fde68a;margin-right:5px;vertical-align:middle"></span>Moderate</span>
            <span class="filter-pill" onclick="setPill(this,'low')"><span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#6ee7b7;margin-right:5px;vertical-align:middle"></span>Minor</span>
            <span class="filter-pill" onclick="setPill(this,'bailable')">Bailable</span>
            <span class="filter-pill" onclick="setPill(this,'non-bailable')">Non-Bailable</span>
        </div>
    </div>
</section>

<section class="section-main">
    <div class="container">
        <div class="results-meta" id="resultsMeta">Showing <span id="resultCount">0</span> categories</div>
        <div class="row g-4" id="catGrid"></div>
        <div class="no-results d-none" id="noResults">
            <i class="fas fa-search"></i>
            <p class="mt-2">No categories found for "<span id="noResultsQuery"></span>"</p>
            <p class="mt-1" style="font-size:.85rem">Try a different keyword or clear your search.</p>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="footer-brand">⚖ Smart Legal</div>
                <div style="color:var(--muted);font-size:.85rem;margin-top:.5rem">Instant legal intelligence for every Indian citizen.</div>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <p style="color:var(--muted);font-size:.85rem">© 2026 Smart Legal Assistance System</p>
            </div>
        </div>
        <div class="footer-disclaimer">
            <i class="fas fa-info-circle me-2" style="color:var(--gold)"></i>
            For Educational & Informational Purpose Only — Not a substitute for professional legal advice. Always consult a qualified advocate for legal matters.
        </div>
    </div>
</footer>

<div class="compare-bar" id="compareBar">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <div style="color:var(--gold-light);font-weight:600;font-size:.88rem;white-space:nowrap"><i class="fas fa-balance-scale me-2"></i>Compare</div>
            <div id="slot1" class="compare-slot"><span>Slot 1</span><button class="slot-remove" onclick="removeCompare(0)">✕</button></div>
            <div style="color:var(--muted);font-size:.9rem">vs</div>
            <div id="slot2" class="compare-slot"><span>Slot 2</span><button class="slot-remove" onclick="removeCompare(1)">✕</button></div>
            <button class="btn-compare-now ms-auto" id="compareNowBtn" onclick="openCompareModal()" disabled><i class="fas fa-columns me-2"></i>Compare Now</button>
            <button style="background:transparent;border:none;color:var(--muted);cursor:pointer;font-size:.85rem" onclick="clearCompare()"><i class="fas fa-times"></i></button>
        </div>
    </div>
</div>

<div class="panel-overlay" id="panelOverlay" onclick="closePanel()"></div>
<div class="side-panel" id="sidePanel">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="hero-badge" style="margin:0;font-size:.72rem" id="panelBadge">IPC Section</div>
        <button class="panel-close" onclick="closePanel()"><i class="fas fa-times"></i></button>
    </div>
    <div id="panelContent"></div>
</div>

<div class="modal fade" id="compareModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="trans-modal-header">
                <div class="trans-modal-icon"><i class="fas fa-columns"></i></div>
                <div><h5 style="color:white;margin:0;font-size:1.05rem">Side-by-Side Comparison</h5><small style="color:var(--muted)">Compare two IPC crime categories</small></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" style="filter:invert(1);opacity:.5"></button>
            </div>
            <div style="padding:1.5rem" id="compareBody"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="translatorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:500px">
        <div class="modal-content">
            <div class="trans-modal-header">
                <div class="trans-modal-icon"><i class="fas fa-globe"></i></div>
                <div><h5 style="color:white;margin:0;font-size:1.05rem">Translate This Page</h5><small style="color:var(--muted)">Select a language and click Translate</small></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" style="filter:invert(1);opacity:.5"></button>
            </div>
            <div class="trans-modal-body">
                <p style="color:var(--muted);font-size:.82rem;margin-bottom:1rem">Choose your preferred language:</p>
                <div class="lang-grid" id="langGrid">
                    <div class="lang-chip" onclick="selectLang(this,'hi')"><span class="lang-flag">🇮🇳</span>Hindi</div>
                    <div class="lang-chip" onclick="selectLang(this,'mr')"><span class="lang-flag">🇮🇳</span>Marathi</div>
                    <div class="lang-chip" onclick="selectLang(this,'gu')"><span class="lang-flag">🇮🇳</span>Gujarati</div>
                    <div class="lang-chip" onclick="selectLang(this,'ta')"><span class="lang-flag">🇮🇳</span>Tamil</div>
                    <div class="lang-chip" onclick="selectLang(this,'te')"><span class="lang-flag">🇮🇳</span>Telugu</div>
                    <div class="lang-chip" onclick="selectLang(this,'kn')"><span class="lang-flag">🇮🇳</span>Kannada</div>
                    <div class="lang-chip" onclick="selectLang(this,'bn')"><span class="lang-flag">🇮🇳</span>Bengali</div>
                    <div class="lang-chip" onclick="selectLang(this,'pa')"><span class="lang-flag">🇮🇳</span>Punjabi</div>
                    <div class="lang-chip" onclick="selectLang(this,'ur')"><span class="lang-flag">🇵🇰</span>Urdu</div>
                    <div class="lang-chip" onclick="selectLang(this,'fr')"><span class="lang-flag">🇫🇷</span>French</div>
                    <div class="lang-chip" onclick="selectLang(this,'de')"><span class="lang-flag">🇩🇪</span>German</div>
                    <div class="lang-chip" onclick="selectLang(this,'en')"><span class="lang-flag">🇬🇧</span>English</div>
                </div>
                <div class="trans-status" id="transStatus"><div class="trans-spinner"></div><span id="transStatusText">Translating page, please wait...</span></div>
            </div>
            <div class="trans-modal-footer">
                <button class="btn-trans-cancel" data-bs-dismiss="modal">Cancel</button>
                <button class="btn-trans-confirm" id="transConfirmBtn" onclick="executePageTranslation()"><i class="fas fa-language me-2"></i> Translate Now</button>
            </div>
        </div>
    </div>
</div>

<div class="toast-container" id="toastContainer"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
<?php echo $categoriesJson; ?>

let currentFilter = 'all';
let compareQueue = [];
let activeCardIds = new Set();

function renderCards(list) {
    const grid = document.getElementById('catGrid');
    const noRes = document.getElementById('noResults');
    const meta = document.getElementById('resultCount');
    grid.innerHTML = '';
    if (!list.length) {
        noRes.classList.remove('d-none');
        document.getElementById('noResultsQuery').textContent = document.getElementById('catSearch').value;
        meta.textContent = '0'; return;
    }
    noRes.classList.add('d-none');
    meta.textContent = list.length;
    list.forEach((cat, idx) => {
        const sevLabel = cat.sev === 'high' ? 'Serious' : cat.sev === 'med' ? 'Moderate' : 'Minor';
        const col = document.createElement('div');
        col.className = 'col-lg-4 col-md-6';
        col.style.animationDelay = (idx * 0.05) + 's';
        col.innerHTML = `
        <div class="cat-card" data-id="${cat.id}" data-sev="${cat.sev}" data-bail="${cat.bailable?'bailable':'non-bailable'}">
            <div class="cat-header">
                <div class="d-flex gap-3 align-items-start flex-grow-1">
                    <div class="cat-icon-wrap" style="background:${cat.iconBg}">${cat.icon}</div>
                    <div><div class="cat-title">${cat.title}</div><div class="cat-ipc">${cat.ipc}</div></div>
                </div>
                <i class="fas fa-chevron-right cat-arrow"></i>
            </div>
            <div class="cat-body">
                <div class="cat-desc">${cat.short}</div>
                <div class="cat-tags">${cat.tags.map(t=>`<span class="cat-tag">${t}</span>`).join('')}</div>
            </div>
            <div class="cat-footer">
                <span class="sev-badge sev-${cat.sev}">${sevLabel}</span>
                <span class="cat-fine"><i class="fas fa-rupee-sign me-1" style="font-size:.7rem"></i>${cat.fine}</span>
            </div>
        </div>`;
        col.querySelector('.cat-card').addEventListener('click', () => openPanel(cat.id));
        grid.appendChild(col);
    });
}

function getFiltered() {
    const q = document.getElementById('catSearch').value.toLowerCase().trim();
    return categories.filter(cat => {
        const matchFilter = currentFilter==='all'||currentFilter===cat.sev||(currentFilter==='bailable'&&cat.bailable)||(currentFilter==='non-bailable'&&!cat.bailable);
        const matchSearch = !q||cat.title.toLowerCase().includes(q)||cat.ipc.toLowerCase().includes(q)||cat.tags.some(t=>t.toLowerCase().includes(q))||cat.desc.toLowerCase().includes(q);
        return matchFilter && matchSearch;
    });
}
function filterCards() { renderCards(getFiltered()); }
function setPill(el, filter) {
    document.querySelectorAll('.filter-pill').forEach(p=>p.classList.remove('active'));
    el.classList.add('active'); currentFilter = filter; filterCards();
}

function openPanel(id) {
    const cat = categories.find(c=>c.id===id);
    if (!cat) return;
    const inCompare = compareQueue.some(c=>c.id===cat.id);
    document.getElementById('panelBadge').textContent = cat.ipc;
    document.getElementById('panelContent').innerHTML = `
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:1.5rem">
            <div style="width:64px;height:64px;border-radius:18px;background:${cat.iconBg};display:flex;align-items:center;justify-content:center;font-size:2rem;flex-shrink:0">${cat.icon}</div>
            <div><div style="font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:800;color:white">${cat.title}</div><div class="panel-ipc-big">${cat.ipc}</div></div>
        </div>
        <div class="panel-section"><div class="panel-section-label"><i class="fas fa-lightbulb"></i> In Simple Words</div>
            <div style="background:rgba(201,168,76,.08);border:1px solid rgba(201,168,76,.2);border-radius:10px;padding:12px 16px;color:#d4c9a8;font-size:.9rem;line-height:1.7">${cat.short}</div></div>
        <div class="panel-section"><div class="panel-section-label"><i class="fas fa-book-open"></i> Legal Definition</div>
            <div class="panel-section-val">${cat.desc}</div></div>
        <div class="panel-section"><div class="panel-section-label"><i class="fas fa-tag"></i> Tags</div>
            <div style="display:flex;flex-wrap:wrap;gap:6px">${cat.tags.map(t=>`<span class="cat-tag">${t}</span>`).join('')}</div></div>
        <div class="panel-section"><div class="panel-section-label"><i class="fas fa-gavel"></i> Punishment & Fine</div>
            <div class="info-row"><span class="info-label">Imprisonment</span><span class="info-val">${cat.punishment}</span></div>
            <div class="fine-highlight"><i class="fas fa-rupee-sign me-2"></i>Fine: ${cat.fine}</div>
            <div class="info-row"><span class="info-label">Bailable</span><span class="info-val">${cat.bailable?'✅ Yes':'❌ No'}</span></div>
            <div class="info-row"><span class="info-label">Cognizable</span><span class="info-val">${cat.cognizable?'✅ Yes':'❌ No'}</span></div>
            <div class="info-row"><span class="info-label">Severity</span><span class="info-val"><span class="sev-badge sev-${cat.sev}">${cat.sev==='high'?'Serious':cat.sev==='med'?'Moderate':'Minor'}</span></span></div>
        </div>
        <div class="panel-section"><div class="panel-section-label"><i class="fas fa-map-marker-alt"></i> Real-World Example</div>
            <div style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:10px;padding:12px 16px;color:var(--text);font-size:.87rem;line-height:1.65;font-style:italic">"${cat.example}"</div></div>
        <div class="panel-section"><div class="panel-section-label"><i class="fas fa-list-check"></i> Steps to Take</div>
            <div style="display:flex;flex-direction:column;gap:8px">
                ${cat.steps.map((s,i)=>`<div style="display:flex;gap:10px;align-items:flex-start"><div style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--gold-light));color:var(--navy);font-size:.7rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px">${i+1}</div><div style="font-size:.86rem;color:var(--text);line-height:1.6">${s}</div></div>`).join('')}
            </div></div>
        <button class="panel-action-btn" onclick="goToSearch('${cat.title}')"><i class="fas fa-search me-2"></i>Search ${cat.title} Laws on Main Page</button>
        <button class="add-compare-btn" id="panelCompareBtn" onclick="addToCompare(${cat.id})">
            ${inCompare?'<i class="fas fa-check me-2"></i>Added to Compare':'<i class="fas fa-columns me-2"></i>Add to Compare'}</button>`;
    document.getElementById('sidePanel').classList.add('open');
    document.getElementById('panelOverlay').classList.add('active');
}
function closePanel() { document.getElementById('sidePanel').classList.remove('open'); document.getElementById('panelOverlay').classList.remove('active'); }
function goToSearch(title) { sessionStorage.setItem('legalSearch', title); window.location.href = 'index.php#form-section'; }

function addToCompare(id) {
    const cat = categories.find(c=>c.id===id);
    if (!cat) return;
    if (compareQueue.some(c=>c.id===id)) { showToast('ℹ️','Already in compare list.'); return; }
    if (compareQueue.length >= 2) { showToast('⚠️','Remove one before adding another.'); return; }
    compareQueue.push(cat); updateCompareBar();
    showToast('✅',`"${cat.title}" added to compare.`);
    const btn = document.getElementById('panelCompareBtn');
    if (btn) { btn.innerHTML = '<i class="fas fa-check me-2"></i>Added to Compare'; btn.disabled = true; }
}
function removeCompare(idx) { compareQueue.splice(idx,1); updateCompareBar(); }
function clearCompare() { compareQueue=[]; updateCompareBar(); }
function updateCompareBar() {
    const bar=document.getElementById('compareBar'),btn=document.getElementById('compareNowBtn'),s1=document.getElementById('slot1'),s2=document.getElementById('slot2');
    if (compareQueue.length===0) { bar.classList.remove('visible'); return; }
    bar.classList.add('visible');
    [s1,s2].forEach((slot,i)=>{ const cat=compareQueue[i]; if(cat){slot.classList.add('filled');slot.querySelector('span').textContent=cat.icon+' '+cat.title;}else{slot.classList.remove('filled');slot.querySelector('span').textContent=`Slot ${i+1}`;}});
    btn.disabled = compareQueue.length < 2;
}
function openCompareModal() {
    if (compareQueue.length<2) return;
    const [a,b]=compareQueue;
    const rows=[
        {label:'IPC Section',ka:a.ipc,kb:b.ipc},
        {label:'Severity',ka:`<span class="sev-badge sev-${a.sev}">${a.sev==='high'?'Serious':a.sev==='med'?'Moderate':'Minor'}</span>`,kb:`<span class="sev-badge sev-${b.sev}">${b.sev==='high'?'Serious':b.sev==='med'?'Moderate':'Minor'}</span>`},
        {label:'Simple Meaning',ka:a.short,kb:b.short},
        {label:'Punishment',ka:a.punishment,kb:b.punishment},
        {label:'Fine (₹)',ka:a.fine,kb:b.fine},
        {label:'Bailable',ka:a.bailable?'✅ Yes':'❌ No',kb:b.bailable?'✅ Yes':'❌ No'},
        {label:'Cognizable',ka:a.cognizable?'✅ Yes':'❌ No',kb:b.cognizable?'✅ Yes':'❌ No'},
        {label:'Tags',ka:a.tags.join(', '),kb:b.tags.join(', ')},
        {label:'Real Example',ka:`<em style="font-size:.83rem">"${a.example}"</em>`,kb:`<em style="font-size:.83rem">"${b.example}"</em>`},
    ];
    document.getElementById('compareBody').innerHTML=`
        <div style="display:grid;grid-template-columns:160px 1fr 1fr;gap:1px;background:var(--glass-border);border-radius:14px;overflow:hidden">
            <div style="background:var(--midnight);padding:1rem"></div>
            <div style="background:linear-gradient(135deg,rgba(201,168,76,.12),rgba(201,168,76,.03));padding:1.2rem;text-align:center"><div style="font-size:2rem">${a.icon}</div><div style="font-family:'Playfair Display',serif;color:white;font-weight:700;margin-top:6px">${a.title}</div></div>
            <div style="background:linear-gradient(135deg,rgba(59,130,246,.1),rgba(59,130,246,.02));padding:1.2rem;text-align:center"><div style="font-size:2rem">${b.icon}</div><div style="font-family:'Playfair Display',serif;color:white;font-weight:700;margin-top:6px">${b.title}</div></div>
            ${rows.map(r=>`<div style="background:rgba(255,255,255,.02);padding:12px 14px;font-size:.75rem;color:var(--muted);text-transform:uppercase;letter-spacing:.8px;display:flex;align-items:center;border-top:1px solid rgba(255,255,255,.04)">${r.label}</div><div style="background:var(--midnight);padding:12px 14px;font-size:.86rem;color:var(--text);line-height:1.5;border-top:1px solid rgba(255,255,255,.04)">${r.ka}</div><div style="background:var(--midnight);padding:12px 14px;font-size:.86rem;color:var(--text);line-height:1.5;border-top:1px solid rgba(255,255,255,.04)">${r.kb}</div>`).join('')}
        </div>
        <div style="display:flex;gap:10px;margin-top:1.25rem">
            <button class="panel-action-btn" style="flex:1" onclick="goToSearch('${a.title}');bootstrap.Modal.getInstance(document.getElementById('compareModal')).hide()">Search ${a.title}</button>
            <button class="panel-action-btn" style="flex:1;background:linear-gradient(135deg,#3b82f6,#60a5fa)" onclick="goToSearch('${b.title}');bootstrap.Modal.getInstance(document.getElementById('compareModal')).hide()">Search ${b.title}</button>
        </div>`;
    new bootstrap.Modal(document.getElementById('compareModal')).show();
}

function showToast(icon,message){const t=document.createElement('div');t.className='custom-toast';t.innerHTML=`<span style="color:var(--gold);margin-right:8px">${icon}</span>${message}`;document.getElementById('toastContainer').appendChild(t);setTimeout(()=>{t.style.transition='opacity .4s';t.style.opacity='0';setTimeout(()=>t.remove(),400);},3000);}
function animateCounter(el,target,suffix=''){let cur=0;const step=Math.ceil(target/40);const t=setInterval(()=>{cur=Math.min(cur+step,target);el.textContent=cur+suffix;if(cur>=target)clearInterval(t);},30);}
window.addEventListener('scroll',()=>{document.getElementById('mainNav').classList.toggle('scrolled',window.scrollY>60);});

let selectedLangCode='',selectedLangName='';
function snapshotOriginals(){const walker=document.createTreeWalker(document.body,NodeFilter.SHOW_TEXT,{acceptNode(node){const p=node.parentElement;if(!p)return NodeFilter.FILTER_REJECT;if(['SCRIPT','STYLE','NOSCRIPT','OPTION'].includes(p.tagName))return NodeFilter.FILTER_REJECT;if(p.closest('#translatorModal')||p.closest('#compareModal'))return NodeFilter.FILTER_REJECT;if(!node.textContent.trim())return NodeFilter.FILTER_REJECT;return NodeFilter.FILTER_ACCEPT;}});while(walker.nextNode()){const n=walker.currentNode;if(!n._origText){n._origText=n.textContent.trim();}}document.querySelectorAll('[placeholder]').forEach(el=>{if(!el._origPlaceholder)el._origPlaceholder=el.getAttribute('placeholder');});}
function openTranslatorModal(){document.querySelectorAll('.lang-chip').forEach(c=>c.classList.remove('selected'));selectedLangCode='';selectedLangName='';document.getElementById('transStatus').style.display='none';const btn=document.getElementById('transConfirmBtn');btn.disabled=false;btn.innerHTML='<i class="fas fa-language me-2"></i> Translate Now';new bootstrap.Modal(document.getElementById('translatorModal')).show();}
function selectLang(el,code){document.querySelectorAll('.lang-chip').forEach(c=>c.classList.remove('selected'));el.classList.add('selected');selectedLangCode=code;selectedLangName=el.querySelector('.lang-flag')?el.textContent.replace(el.querySelector('.lang-flag').textContent,'').trim():el.textContent.trim();}
async function translateText(text,lang){if(!text.trim())return text;try{const res=await fetch(`https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=${lang}&dt=t&q=${encodeURIComponent(text)}`);const data=await res.json();return data[0].map(c=>c[0]).join('');}catch(e){return text;}}
async function executePageTranslation(){if(!selectedLangCode){showToast('⚠️','Please select a language first.');return;}const status=document.getElementById('transStatus'),confirmBtn=document.getElementById('transConfirmBtn');status.style.display='flex';confirmBtn.disabled=true;if(selectedLangCode==='en'){document.getElementById('transStatusText').textContent='Restoring English...';const walker=document.createTreeWalker(document.body,NodeFilter.SHOW_TEXT,{acceptNode(node){if(!node._origText)return NodeFilter.FILTER_REJECT;const p=node.parentElement;if(!p||['SCRIPT','STYLE','NOSCRIPT','OPTION'].includes(p.tagName))return NodeFilter.FILTER_REJECT;if(p.closest('#translatorModal')||p.closest('#compareModal'))return NodeFilter.FILTER_REJECT;return NodeFilter.FILTER_ACCEPT;}});while(walker.nextNode()){const n=walker.currentNode;if(n._origText)n.textContent=n._origText;}document.querySelectorAll('[placeholder]').forEach(el=>{if(el._origPlaceholder)el.setAttribute('placeholder',el._origPlaceholder);});bootstrap.Modal.getInstance(document.getElementById('translatorModal')).hide();showToast('✅','Page restored to English!');return;}const textNodes=[];const walker=document.createTreeWalker(document.body,NodeFilter.SHOW_TEXT,{acceptNode(node){if(!node._origText)return NodeFilter.FILTER_REJECT;const p=node.parentElement;if(!p||['SCRIPT','STYLE','NOSCRIPT','OPTION'].includes(p.tagName))return NodeFilter.FILTER_REJECT;if(p.closest('#translatorModal')||p.closest('#compareModal'))return NodeFilter.FILTER_REJECT;return NodeFilter.FILTER_ACCEPT;}});while(walker.nextNode())textNodes.push(walker.currentNode);const placeholders=[...document.querySelectorAll('[placeholder]')].filter(e=>e._origPlaceholder);const total=textNodes.length+placeholders.length;let done=0;const tick=()=>{done++;document.getElementById('transStatusText').textContent=`Translating to ${selectedLangName}... ${Math.min(100,Math.round(done/total*100))}%`;};const BATCH=8;for(let i=0;i<textNodes.length;i+=BATCH){await Promise.all(textNodes.slice(i,i+BATCH).map(async node=>{const tr=await translateText(node._origText,selectedLangCode);const orig=node.textContent;node.textContent=orig.match(/^\s*/)[0]+tr+orig.match(/\s*$/)[0];tick();}));}for(let i=0;i<placeholders.length;i+=BATCH){await Promise.all(placeholders.slice(i,i+BATCH).map(async el=>{el.setAttribute('placeholder',await translateText(el._origPlaceholder,selectedLangCode));tick();}));}bootstrap.Modal.getInstance(document.getElementById('translatorModal')).hide();showToast('🌐',`Page translated to ${selectedLangName}!`);}

document.addEventListener('DOMContentLoaded',()=>{
    renderCards(categories);
    snapshotOriginals();
    animateCounter(document.getElementById('sc1'),categories.length);
    animateCounter(document.getElementById('sc2'),categories.length,'+');
    animateCounter(document.getElementById('sc3'),categories.filter(c=>c.bailable).length);
    animateCounter(document.getElementById('sc4'),categories.filter(c=>!c.bailable).length);
    const obs=new IntersectionObserver(entries=>{entries.forEach(e=>{if(e.isIntersecting){e.target.style.opacity='1';e.target.style.transform='translateY(0)';}});},{threshold:0.08});
    document.querySelectorAll('.cat-card').forEach(el=>{el.style.opacity='0';el.style.transform='translateY(20px)';el.style.transition='opacity .5s ease, transform .5s ease';obs.observe(el);});
    const pre=sessionStorage.getItem('legalSearch');
    if(pre){sessionStorage.removeItem('legalSearch');}
});
</script>
</body>
</html>