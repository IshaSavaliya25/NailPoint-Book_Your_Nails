<?php
$cssFile = "css/custom.css";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newCSS = $_POST['css_content'] ?? '';
    file_put_contents($cssFile, $newCSS);
    echo "<p>CSS updated successfully. <a href='about.html'>View About Page</a></p>";
}
$currentCSS = file_exists($cssFile) ? file_get_contents($cssFile) : '';
?>

<h2>Edit CSS for About Page</h2>
<form method="POST">
    <textarea name="css_content" rows="25" cols="100"><?= htmlspecialchars($currentCSS) ?></textarea><br><br>
    <input type="submit" value="Update CSS">
</form>

// http://localhost/ish-nails/edit_css.php run this code