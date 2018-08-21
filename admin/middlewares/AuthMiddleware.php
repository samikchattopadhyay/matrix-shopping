<?php 

use Pecee\Http\Request;
use Pecee\Http\Middleware\IMiddleware;

class AuthMiddleware implements IMiddleware {

    public function handle(Request $request): void 
    {
        // Allow actions from AuthController
        $allowedRoutes = ['login', 'retrieve-password', 'change-forgotten-password'];
        $currentRoute = str_replace('/', '', $request->getUrl()->getOriginalUrl());
        $allowed = in_array($currentRoute, $allowedRoutes);
        
        // Get authenticated users data from session
        $request->user = session('AUTHENTICATION')->get('user', null);
        
        // If already logged in, then dont show auth links
        if ( !empty($request->user) && $allowed) {
            redirect(url('dashboard.index'));
        }
        
        // If authentication failed, redirect request to user-login page.
        if($request->user === null && !$allowed) {
            redirect(url('auth.login'));
        }
    }
}