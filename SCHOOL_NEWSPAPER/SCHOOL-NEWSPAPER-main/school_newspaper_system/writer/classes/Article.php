<?php require_once __DIR__ . '/Database.php';

require_once __DIR__ . '/Database.php';
class Article
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->pdo();
    }
    public function create($title, $body, $image, $author_id)
    {
        $stmt = $this->db->prepare('INSERT INTO articles (title,content,image,writer_id) VALUES (?,?,?,?)');
        return $stmt->execute([$title, $body, $image, $author_id]);
    }
    public function all()
    {
        $stmt = $this->db->query('SELECT a.*, u.name AS author_name FROM articles a JOIN users u ON a.id=u.id ORDER BY a.created_at DESC');
        return $stmt->fetchAll();
    }
    public function get($id)
    {
        $stmt = $this->db->prepare('SELECT a.*, u.name AS author_name FROM articles a JOIN users u ON a.id=u.id WHERE a.id=?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM articles WHERE id=?');
        return $stmt->execute([$id]);
    }
    public function byAuthor($author_id)
    {
        $stmt = $this->db->prepare('SELECT * FROM articles WHERE author_id=? ORDER BY created_at DESC');
        $stmt->execute([$author_id]);
        return $stmt->fetchAll();
    }
}
?>