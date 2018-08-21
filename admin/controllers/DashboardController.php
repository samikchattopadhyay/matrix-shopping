<?php 

class DashboardController {
    
    public function index() {
        
        // Call view function to load the blade view
        return view('dash.index', []);
    }
    
}