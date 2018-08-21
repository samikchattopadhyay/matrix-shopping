<?php 

class Model {
    
    protected $database;
    
    public function __construct() {
        
        $db = Database::singleton();
        $this->database = $db->Connection();
        
    }
}