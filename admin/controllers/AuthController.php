<?php 

class AuthController {
    
    public function logout() {
        session(true)->destroy();
        redirect(url('auth.login'));
    }
    
    public function login() {
        
        $email = input()->post('email');
        $password = input()->post('password');
        $login = input()->post('login', false);
        
        if ($login) {
            if ($email && $password) {
                $user = new UserModel();
                $authenticatedUser = $user->authenticate($email, $password, 'Admin');
                if ($authenticatedUser === false) {
                    redirect(url('auth.login'));
                } else {
                    session('AUTHENTICATION')->set('user', $authenticatedUser);
                    redirect(url('dashboard'));
                }
            }
        } else {
            return view('auth.login', []);
        }
    }
    
    public function retrieve() {
        return view('auth.retrieve', []);
    }
    
}