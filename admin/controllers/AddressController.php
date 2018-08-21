<?php 

class AddressController {
    
    // List all address
    public function list() {
        
        $addressModel = new AddressModel();
        $addresses = $addressModel->getAll();
        
        return view('address.list', [
            'addresses' => $addresses,
        ]);
    }
    
    // Add new Address
    public function add() {
        
        $stateModal = new StateModel();
        $states = $stateModal->getAll();
        
        return view('address.form', [
            'states' => $states,
            'action' => 'Add New',
        ]);
    }
    
    // Edit existing Address
    public function edit($id) {
        
        $addressModel = new AddressModel();
        $address = $addressModel->getById($id);
        
        $stateModal = new StateModel();
        $states = $stateModal->getAll();
        
        $cityModel = new CityModel();
        $cities = $cityModel->getByState($address->state_id);
        
        return view('address.form', [
            'address' => $address,
            'states' => $states,
            'cities' => $cities,
            'action' => 'Edit',
        ]);
    }
    
    // POST - Save address
    public function save() {
        
        $postData = input()->all();
        $addressModel = new AddressModel();
        
        if (isset($postData['id']) && !empty($postData['id'])) {
            $act = 'edit';
            $res = $addressModel->updateById($postData['id'], $postData);
            $msg = $res ? 'Address has been updated' : 'Sorry! Failed to update the address';
        } else {
            $act = 'add';
            $res = $addressModel->addNew($postData);
            $msg = $res ? 'New address has been recorded' : 'Sorry! Failed to save the address';
        }
        
        sleep(1);
        return json_encode(array(
            'action' => $act,
            'location' => url('listAddress'),
            'success' => $res,
            'message' => $msg
        ));
    }
    
    public function delete($id) {
        
        $addressModel = new AddressModel();
        $res = $addressModel->deleteById($id);
        
        if ($res) {
            $msg = "Address (ID #{$id}) has been deleted";
        } else {
            $msg = "Sorry! An unknown error has been occurred";
        }
        
        sleep(1);
        return json_encode(array(
            'success' => $res,
            'message' => $msg
        ));
    }
    
    // Find state ID and city ID by the PIN
    public function findByPin($pin) {
        $addressModel = new AddressModel();
        $address = $addressModel->findByPin($pin);
        return json_encode($address);
    }
    
}