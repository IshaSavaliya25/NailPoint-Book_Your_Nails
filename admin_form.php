<?php
$host = "localhost";
$dbname = "ish_nails";
$username = "root"; // change if needed
$password = "";     // change if needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}

// Save form data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($_POST as $section => $content) {
        $stmt = $pdo->prepare("UPDATE site_content SET content = :content WHERE section = :section");
        $stmt->execute(['content' => $content, 'section' => $section]);
    }
    $message = "Content updated successfully!";
}

// Load current data
$stmt = $pdo->query("SELECT section, content FROM site_content");
$contentData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Content Editor</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: auto; padding: 20px; }
        label { display: block; margin-top: 20px; font-weight: bold; }
        input[type="text"], textarea { width: 100%; padding: 10px; margin-top: 5px; }
        input[type="submit"] { margin-top: 20px; padding: 10px 20px; }
        .message { color: green; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Edit Website Content</h1>
    <?php if (!empty($message)) echo "<div class='message'>$message</div>"; ?>
    <form method="POST">
        <label>About Heading</label>
        <input type="text" name="about_heading" value="<?php echo htmlspecialchars($contentData['about_heading']); ?>">

        <label>About Description</label>
        <textarea name="about_description"><?php echo htmlspecialchars($contentData['about_description']); ?></textarea>

        <label>Contact Phone</label>
        <input type="text" name="contact_phone" value="<?php echo htmlspecialchars($contentData['contact_phone']); ?>">

        <label>Gallery Title</label>
        <input type="text" name="gallery_title" value="<?php echo htmlspecialchars($contentData['gallery_title']); ?>">

        <label>Home Welcome Message</label>
        <input type="text" name="home_welcome" value="<?php echo htmlspecialchars($contentData['home_welcome']); ?>">

        <input type="submit" value="Save Changes">
    </form>
</body>
</html>
