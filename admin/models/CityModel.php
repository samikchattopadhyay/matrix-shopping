<?php 
class CityModel extends Model
{
    public function getAll() 
    {
        return $this->database->query('SELECT id,name FROM cities')->fetchAll();
    }
    
    public function getByState($id)
    {
        return $this->database->query('SELECT id,name FROM cities WHERE state_id=?', $id)->fetchAll();
    }
}

