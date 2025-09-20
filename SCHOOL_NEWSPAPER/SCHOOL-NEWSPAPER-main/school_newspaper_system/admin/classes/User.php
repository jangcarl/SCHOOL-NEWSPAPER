<?php

require_once __DIR__ . '/Database.php';
class User
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->pdo();
    }
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    public function create($name, $email, $password, $role = 'writer')
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)');
        return $stmt->execute([$name, $email, $hash, $role]);
    }
    public function allWriters()
    {
        $stmt = $this->db->query("SELECT * FROM users WHERE role='writer' ORDER BY name");
        return $stmt->fetchAll();
    }
    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id=?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
?>