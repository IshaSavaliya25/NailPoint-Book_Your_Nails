<?php
$pdo = new PDO("mysql:host=localhost;dbname=ish_nails", "root", "");
$stmt = $pdo->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
$items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gallery</title>
    <style>
        .gallery { display: flex; flex-wrap: wrap; gap: 20px; padding: 20px; }
        .gallery-item { width: 200px; }
        img, video { width: 100%; height: auto; }
    </style>
</head>
<body>
    <h1>Our Gallery</h1>
    <div class="gallery">
        <?php foreach ($items as $item): ?>
            <div class="gallery-item">
                <?php if ($item['filetype'] === 'image'): ?>
                    <img src="uploads/<?php echo $item['filename']; ?>" alt="">
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
