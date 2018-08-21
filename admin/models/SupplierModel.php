<?php 
class SupplierModel extends Model
{
    
    public function getById($id)
    {
        $query = "SELECT
            s.id, s.name, s.contact_person,
            a.locality, c.name AS city, a.phone, a.mobile
        FROM suppliers as s
        INNER JOIN address as a on a.id = s.address_id
        INNER JOIN cities as c ON c.id = a.city_id
        WHERE s.id='{$id}';";
        
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
            s.id, s.name, s.contact_person,
            a.locality, c.name AS city, a.phone, a.mobile
        FROM suppliers as s
        INNER JOIN address as a on a.id = s.address_id
        INNER JOIN cities as c ON c.id = a.city_id
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
    
    public function addNew($data) {
        unset($data['id']);
        try {
            $this->database->query('INSERT INTO suppliers ?', $data);
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
            $result = $this->database->query('UPDATE suppliers SET', $data, 'WHERE id = ?', $id);
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
            $result = $this->database->query('DELETE FROM suppliers WHERE id = ?', $id);
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
}

