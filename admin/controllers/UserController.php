<?php 

class UserController {
    
    public function profile() {
        
        $data = array(
            'user_id' => 230,
            'name' => 'Samik Chattopadhyay'
        );
        return view('user.profile', $data);
    }
    
}