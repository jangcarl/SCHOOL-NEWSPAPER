<?php
require_once __DIR__ . '/../classloader.php';
require_once __DIR__ . '/../classes/Article.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['post_article'])) {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $author = $_POST['author_id'];
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $targetDir = __DIR__ . '/uploads';
            if (!is_dir($targetDir))
                mkdir($targetDir, 0755, true);
            $filename = uniqid('img_') . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . '/' . $filename);
            $imagePath = 'uploads/' . $filename;
        }
        (new Article())->create($title, $body, $imagePath, $author);
        header('Location: ../index.php');
        exit;
    }
}
?>