<?php
include 'includes/db_connection.php';

// Optional: Clear old data first (uncomment if you want fresh import)
// $pdo->exec("TRUNCATE TABLE laws");

$json_file = 'database/laws.json';
$data = json_decode(file_get_contents($json_file), true);

if (!$data || !isset($data['laws'])) {
    die("Error: laws.json not found or invalid!");
}

$stmt = $pdo->prepare("INSERT INTO laws (category, section, title, description, punishment, keywords) 
                       VALUES (?, ?, ?, ?, ?, ?)");

$imported = 0;
foreach ($data['laws'] as $law) {
    $stmt->execute([
        $law['category'],
        $law['section'],
        $law['title'],
        $law['description'],
        $law['punishment'],
        $law['keywords']
    ]);
    $imported++;
}

echo "<h2 style='color:green;text-align:center;margin-top:50px;'>✅ Success! $imported laws imported into MySQL table.</h2>";
echo "<p style='text-align:center;'><a href='index.php' class='btn btn-primary'>Go to Home Page</a></p>";
?>
