<?php 

class CategoryController {
    
    // List of categories
    public function list($pid = 0) {
        
        $categoryTree = array();
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllWithThisPid($pid);
        
        if ($pid > 0) {
            $parents = [];
            $categoryTree = $categoryModel->getCategoryTree($pid, $parents);
        }
        
        return view('catalog.category.list', [
            'categories' => $categories,
            'categoryTree' => $categoryTree
        ]);
    }
    
    // GET - Add new supplier
    public function add($pid = 0) {
        
        $categoryModel = new CategoryModel();
        $selectables = $categoryModel->to_select();
        
        return view('catalog.category.form', array(
            'categories' => $selectables,
            'action' => 'Add New',
            'pid' => $pid,
        ));
    }
    
    // GET - Edit existing category
    public function edit($id) {
        
        $categoryModel = new CategoryModel();
        $selectables = $categoryModel->to_select();
        $category = $categoryModel->getById($id);
        
        return view('catalog.category.form', [
            'categories' => $selectables,
            'category' => $category,
            'action' => 'Edit',
        ]);
    }
    
    // POST - Save new category
    public function save() {
        
        $postData = input()->all();
        $categoryModel = new CategoryModel();
        
        if (isset($postData['id']) && !empty($postData['id'])) {
            $act = 'edit';
            $res = $categoryModel->update($postData['id'], $postData['name'], $postData);
            $msg = $res ? 'Category has been updated' : 'Sorry! Failed to update the category';
        } else {
            $act = 'add';
            $res = $categoryModel->add($postData['pid'], $postData['name'], false, $postData);
            $msg = $res ? 'New category has been added' : 'Sorry! Failed to save the category';
        }
        
        sleep(2);
        return json_encode(array(
            'action' => $act,
            'location' => url('listCategories'),
            'success' => $res,
            'message' => $msg
        ));
    }
    
    // DELETE - delete a category
    public function delete($id) {
        
        $categoryModel = new CategoryModel();
        $res = $categoryModel->delete($id);
        
        if ($res) {
            $msg = "Category (ID #{$id}) has been deleted";
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