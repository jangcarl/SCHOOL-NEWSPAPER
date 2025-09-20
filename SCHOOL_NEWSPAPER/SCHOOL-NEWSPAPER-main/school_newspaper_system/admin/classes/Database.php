<?php require_once __DIR__ . '/../../includes/config.php';
class Database
{
    private static $inst = null;
    private $pdo;
    private function __construct()
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $this->pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
    public static function getInstance()
    {
        if (self::$inst === null)
            self::$inst = new Database();
        return self::$inst;
    }
    public function pdo()
    {
        return $this->pdo;
    }
}
?>