<?php 

class ErrorController {
    
    public function http404() {
        return view('errors.404', []);
    }
    
}