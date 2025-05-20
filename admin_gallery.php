<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<?php
$pdo = new PDO("mysql:host=localhost;dbname=ish_nails", "root", "");

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['gallery_file'])) {
    $file = $_FILES['gallery_file'];
    $fileName = basename($file['name']);
    $targetDir = "uploads/";
    $targetFile = $targetDir . $fileName;

    $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedImages = ['jpg', 'jpeg', 'png', 'gif'];
    $allowedVideos = ['mp4', 'webm', 'mov'];

    if (in_array($ext, $allowedImages)) {
        $type = 'image';
    } elseif (in_array($ext, $allowedVideos)) {
        $type = 'video';
    } else {
        echo "<p style='color:red;'>Unsupported file type.</p>";
        exit;
    }

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        $stmt = $pdo->prepare("INSERT INTO gallery (filename, filetype) VALUES (?, ?)");
        $stmt->execute([$fileName, $type]);
    } else {
        echo "<p style='color:red;'>Upload failed.</p>";
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("SELECT filename FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $file = $stmt->fetchColumn();

    if ($file && file_exists("uploads/$file")) {
        unlink("uploads/$file");
    }

    $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin_gallery.php");
    exit;
}

// Fetch gallery items
$stmt = $pdo->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Gallery</title>
    <style>
        body { font-family: Arial; padding: 20px; max-width: 800px; margin: auto; }
        .gallery { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-top: 30px; }
        .item { border: 1px solid #ccc; padding: 10px; text-align: center; position: relative; }
        video, img { max-width: 100%; height: auto; }
        .delete-btn {
            color: red; position: absolute; top: 5px; right: 10px; text-decoration: none;
            font-weight: bold; background: #fff; padding: 2px 6px; border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h1>Manage Gallery</h1>

    <form method="POST" enctype="multipart/form-data">
        <label>Select Photo or Video to Upload:</label>
        <input type="file" name="gallery_file" required>
        <button type="submit">Upload</button>
    </form>

    <div class="gallery">
        <?php foreach ($items as $item): ?>
            <div class="item">
                <a class="delete-btn" href="?delete=<?php echo $item['id']; ?>" onclick="return confirm('Delete this item?')">×</a>
                <?php if ($item['filetype'] === 'image'): ?>
                    <img src="uploads/<?php echo $item['filename']; ?>" alt="Gallery image">
                <?php else: ?>
                    <video controls>
                        <source src="uploads/<?php echo $item['filename']; ?>" type="video/mp4">
                        Your browser does not support video.
                    </video>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>

