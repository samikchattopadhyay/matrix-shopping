<?php 
class StateModel extends Model
{
    public function getAll() {
        return $this->database->query('SELECT id,name FROM states')->fetchAll();
    }
}

