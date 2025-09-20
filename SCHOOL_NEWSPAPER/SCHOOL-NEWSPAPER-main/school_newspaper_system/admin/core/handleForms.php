<?php
require_once __DIR__ . '/../classloader.php';
require_once __DIR__ . '/../classes/Article.php';
require_once __DIR__ . '/../classes/User.php';
$articleModel = new Article();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['delete_article'])){
        $id = $_POST['article_id'];
        // find article to get author
        $a = $articleModel->get($id);
        if($articleModel->delete($id)){
            // send simple notification by inserting into notifications table
            $db = (Database::getInstance())->pdo();
            $stmt = $db->prepare('INSERT INTO notifications (user_id,message) VALUES (?,?)');
            $stmt->execute([$a['author_id'], 'Your article "' . $a['title'] . '" was deleted by admin.']);
            header('Location: index.php?msg=deleted'); exit;
        } else {
            header('Location: index.php?msg=err'); exit;
        }
    }
    if(isset($_POST['grant_access'])){
        // simplified grant: insert into shared_access
        $db = (Database::getInstance())->pdo();
        $stmt = $db->prepare('INSERT INTO shared_access (article_id,writer_id,granted_by) VALUES (?,?,?)');
        $stmt->execute([$_POST['article_id'], $_POST['writer_id'], $_POST['admin_id']]);
        header('Location: index.php?msg=granted'); exit;
    }
}
?>