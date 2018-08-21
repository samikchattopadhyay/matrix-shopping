<?php 

class AddressModel extends Model
{
    public function getById($id) 
    {
        $query = "SELECT
            a.id,a.address,a.locality,a.city_id,a.pin,
            a.state_id,a.country_id,a.mobile,a.mobile2,
            a.mobile3,a.phone,a.phone2,a.phone3,
            a.email,a.email2,a.email3,a.fax,a.fax2,
            a.fax3, c.name as city,s.name as state
        FROM address as a
        LEFT JOIN cities as c ON c.id = a.city_id
        LEFT JOIN states as s ON s.id = a.state_id
        WHERE a.id='{$id}';";
        try {
            return $this->database->query($query)->fetch();
        } catch (Exception $e) {
            logErrors($e->getMessage(), E_ERROR, [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'class' => __CLASS__,
                'method' => __METHOD__,
                'function' => __FUNCTION__
            ]);
        }
        
        return false;
    }
    
    public function getAll($order = 'ASC') {
        $query = "SELECT
            a.id,a.address,a.locality,a.city_id,a.pin,
            a.state_id,a.country_id,a.mobile,a.mobile2,
            a.mobile3,a.phone,a.phone2,a.phone3,
            a.email,a.email2,a.email3,a.fax,a.fax2,
            a.fax3, c.name as city,s.name as state
        FROM address as a
        LEFT JOIN cities as c ON c.id = a.city_id
        LEFT JOIN states as s ON s.id = a.state_id
        ORDER BY a.id {$order}";
        try {
            return $this->database->query($query)->fetchAll();
        } catch (Exception $e) {
            logErrors($e->getMessage(), E_ERROR, [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'class' => __CLASS__,
                'method' => __METHOD__,
                'function' => __FUNCTION__
            ]);
        }
        
        return false;
    }
    
    public function addNew($data) 
    {
        unset($data['id']);
        $data['country_id'] = 1;
        try {
            $this->database->query('INSERT INTO address ?', $data);
            return $this->database->getInsertId();
        } catch (Exception $e) {
            logErrors($e->getMessage(), E_ERROR, [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'class' => __CLASS__,
                'method' => __METHOD__,
                'function' => __FUNCTION__
            ]);
        }
        
        return false;
    }
    
    public function updateById($id, $data) 
    {
        unset($data['id']);
        try {
            $result = $this->database->query('UPDATE address SET', $data, 'WHERE id = ?', $id);
            return $result->getRowCount();
        } catch (Exception $e) {
            logErrors($e->getMessage(), E_ERROR, [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'class' => __CLASS__,
                'method' => __METHOD__,
                'function' => __FUNCTION__
            ]);
        }
        
        return false;
    }
    
    public function deleteById($id) 
    {
        try {
            $result = $this->database->query('DELETE FROM address WHERE id = ?', $id);
            return $result->getRowCount();
        } catch (Exception $e) {
            logErrors($e->getMessage(), E_ERROR, [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'class' => __CLASS__,
                'method' => __METHOD__,
                'function' => __FUNCTION__
            ]);
        }
        
        return false;
    }
    
    public function findByPin($pin) 
    {
        return $this->database->query('SELECT
            city_id,state_id,country_id
        FROM address WHERE pin = ? 
        LIMIT 1', $pin)->fetch();
    }
}

