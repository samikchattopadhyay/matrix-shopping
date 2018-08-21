<?php 
class UserModel extends Model
{
    public function authenticate($email, $password, $who = 'Customer') {
        return array(
            'user_id' => 100,
            'name' => 'Samik Chattopadhyay'
        );
    }
    
    
    
    public function demo() {
        
        $this->database->query('INSERT INTO users ?', [ // here can be omitted question mark
            'name' => 'Samik Chattopadhyay',
            'mobile' => '9231571612',
        ]);
        
        echo 'Insert ID = ' . $this->database->getInsertId(); // returns the auto-increment of inserted row
        
        $this->database->query('INSERT INTO users', [
            'name' => 'Sunetra Chattopadhyay',
            'mobile' => '9154637728',
        ], [
            'name' => 'Avik Chattopadhyay',
            'mobile' => '9234828839',
        ]);
        
        
        $this->database->query('INSERT INTO users', [
            'name' => 'Sarat Chattopadhyay',
            'mobile' => '9233475882'
        ]);
        
        
        $result = $this->database->query('SELECT * FROM users');
        $result = $this->database->query('SELECT * FROM users WHERE name LIKE ?', 'Samik');
        $result = $this->database->query('SELECT * FROM users WHERE name LIKE ? AND status = ?', 'Samik', 'ACTIVE');
        $result = $this->database->query('SELECT * FROM users WHERE user_id IN (?)', [2,3]); // $ids is array
        
        foreach ($result as $row) {
            echo $row->user_id;
            echo $row->name;
        }
        
        echo $result->getRowCount();
        
        // returns the associative array id => name
        $pairs = $this->database->fetchPairs('SELECT user_id, name FROM users');
        // returns all rows as array
        $rows = $this->database->fetchAll('SELECT * FROM users');
        // returns single row
        $row = $this->database->fetch('SELECT * FROM users WHERE user_id = ?', 2);
        // return single field
        $name = $this->database->fetchField('SELECT name FROM users WHERE user_id = ?', 3);
        
    }
}

