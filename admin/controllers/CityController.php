<?php 

class CityController {
    
    // List all address inside a state
    public function listByState($id) {
        
        $cityModel = new CityModel();
        $cities = $cityModel->getByState($id);
        return json_encode($cities);
    }
}