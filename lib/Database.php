<?php 

class Database {
    
    private $dsn = 'mysql:host=localhost;dbname=mukundabazar';
    private $user = 'root';
    private $password = 'root';
    private $database;
    private static $instance;
    
    public static function singleton()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function __construct() {
        $this->database = new Nette\Database\Connection($this->dsn, $this->user, $this->password);
    }
    
    public function Connection() {
        return $this->database;
    }
}
