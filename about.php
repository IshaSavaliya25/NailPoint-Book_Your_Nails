<?php
$pdo = new PDO("mysql:host=localhost;dbname=ish_nails", "root", "");
$stmt = $pdo->query("SELECT section, content FROM site_content");
$content = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
?>
<!DOCTYPE html>
<html>
<head><title>About Us</title></head>
<body>
    <h1><?php echo $content['about_heading']; ?></h1>
    <p><?php echo $content['about_description']; ?></p>
</body>
</html>
