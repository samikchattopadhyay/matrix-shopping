<?php 

class SupplierController {
    
    // List of suppliers
    public function list() {
        
        $supplierModel = new SupplierModel();
        $suppliers = $supplierModel->getAll();
        
        return view('catalog.suppliers.list', [
            'suppliers' => $suppliers
        ]);
    }
    
    // GET - Add new supplier
    public function add() {
        
        $addressModel = new AddressModel();
        $addresses = $addressModel->getAll();
        
        return view('catalog.suppliers.form', array(
            'addresses' => $addresses,
            'action' => 'Add New',
        ));
    }

    // GET - Edit existing supplier
    public function edit($id) {
        
        $supplierModel = new SupplierModel();
        $supplier = $supplierModel->getById($id);
        
        $addressModel = new AddressModel();
        $addresses = $addressModel->getAll();
        
        return view('catalog.suppliers.form', [
            'supplier' => $supplier,
            'addresses' => $addresses,
            'action' => 'Edit',
        ]);
    }
    
    // POST - Save new supplier
    public function save() {
        
        $postData = input()->all();
        $supplierModel = new SupplierModel();
        
        if (isset($postData['id']) && !empty($postData['id'])) {
            $act = 'edit';
            $res = $supplierModel->updateById($postData['id'], $postData);
            $msg = $res ? 'Supplier details has been updated' : 'Sorry! Failed to update the supplier details';
        } else {
            $act = 'add';
            $res = $supplierModel->addNew($postData);
            $msg = $res ? 'New supplier has been recorded' : 'Sorry! Failed to save the supplier';
        }
        
        sleep(2);
        return json_encode(array(
            'action' => $act,
            'location' => url('listSuppliers'),
            'success' => $res,
            'message' => $msg
        ));
    }
    
    // DELETE - delete a supplier
    public function delete($id) {
        
        $supplierModel = new SupplierModel();
        $res = $supplierModel->deleteById($id);
        
        if ($res) {
            $msg = "Supplier (ID #{$id}) has been deleted";
        } else {
            $msg = "Sorry! An unknown error has been occurred";
        }
        
        sleep(3);
        return json_encode(array(
            'success' => $res,
            'message' => $msg
        ));
    }
    
}