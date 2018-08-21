<?php

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;


// Auth controller
SimpleRouter::get('/logout', 'AuthController@logout')->name('auth.logout');

SimpleRouter::group(['middleware' => AuthMiddleware::class], function () {
    
    // Auth controller -------------------------------------------------------
    SimpleRouter::match(['get', 'post'], '/login', 'AuthController@login')->name('auth.login');
    SimpleRouter::match(['get', 'post'], '/retrieve-password', 'AuthController@retrieve')->name('auth.retrieve');
    SimpleRouter::match(['get', 'post'], '/change-forgotten-password', 'AuthController@change')->name('auth.change');
    
    // Dashboard Controller -------------------------------------------------------
    SimpleRouter::get('/', 'DashboardController@index')->name('root');
    SimpleRouter::get('/dashboard', 'DashboardController@index')->name('dashboard');
        
    // Supplier Controller -------------------------------------------------------
    SimpleRouter::get('/catalog/suppliers', 'SupplierController@list')->name('listSuppliers');
    SimpleRouter::get('/catalog/supplier/add', 'SupplierController@add')->name('addSupplier');
    SimpleRouter::get('/catalog/supplier/edit/{id}', 'SupplierController@edit')->name('editSupplier');
    SimpleRouter::post('/catalog/supplier/save', 'SupplierController@save')->name('saveSupplier');
    SimpleRouter::delete('/catalog/supplier/delete/{id}', 'SupplierController@delete')->name('deleteSupplier');

    // Category Controller -------------------------------------------------------
    SimpleRouter::get('/catalog/categories/{pid?}', 'CategoryController@list')->name('listCategories');
    SimpleRouter::get('/catalog/add-category/{pid?}', 'CategoryController@add')->name('addCategory');
    SimpleRouter::get('/catalog/edit-category/{id}', 'CategoryController@edit')->name('editCategory');
    SimpleRouter::post('/catalog/save-category', 'CategoryController@save')->name('saveCategory');
    SimpleRouter::delete('/catalog/delete-category/{id}', 'CategoryController@delete')->name('deleteCategory');
    
    // Products Controller -------------------------------------------------------
    SimpleRouter::get('/catalog/products', 'ProductController@list')->name('listProducts');
    SimpleRouter::get('/catalog/add-product', 'ProductController@add')->name('addProduct');
    SimpleRouter::get('/catalog/edit-product/{id}', 'ProductController@edit')->name('editProduct');
    SimpleRouter::post('/catalog/save-product', 'ProductController@save')->name('saveProduct');
    SimpleRouter::delete('/catalog/delete-product/{id}', 'ProductController@delete')->name('deleteProduct');
    
    // Address Controller -------------------------------------------------------
    SimpleRouter::get('/address/list', 'AddressController@list')->name('listAddress');
    SimpleRouter::get('/address/add', 'AddressController@add')->name('addAddress');
    SimpleRouter::get('/address/edit/{id}', 'AddressController@edit')->name('editAddress');
    SimpleRouter::post('/address/save', 'AddressController@save')->name('saveAddress');
    SimpleRouter::delete('/address/delete/{id}', 'AddressController@delete')->name('deleteAddress');
    SimpleRouter::get('/address/find-by-pin/{pin}', 'AddressController@findByPin')->name('findByPin');
    
    // City Controller -------------------------------------------------------
    SimpleRouter::get('/city-list/filter-by-state/{id}', 'CityController@listByState')->name('listCityByStateId');

});

// Matrix Admin Controller  -------------------------------------------------------
SimpleRouter::get('/matrix/dashboard', 'MatrixController@dashboard')->name('matrix.dashboard');
SimpleRouter::get('/matrix/charts', 'MatrixController@charts')->name('matrix.charts');
SimpleRouter::get('/matrix/widgets', 'MatrixController@widgets')->name('matrix.widgets');
SimpleRouter::get('/matrix/tables', 'MatrixController@tables')->name('matrix.tables');
SimpleRouter::get('/matrix/grid', 'MatrixController@grid')->name('matrix.grid');

SimpleRouter::get('/matrix/form/basic', 'MatrixController@formBasic')->name('matrix.form.basic');
SimpleRouter::get('/matrix/form/wizard', 'MatrixController@formWizard')->name('matrix.form.wizard');

SimpleRouter::get('/matrix/icon/material', 'MatrixController@iconMaterial')->name('matrix.icon.material');
SimpleRouter::get('/matrix/icon/fontawesome', 'MatrixController@iconFontawesome')->name('matrix.icon.fontawesome');

SimpleRouter::get('/matrix/pages/buttons', 'MatrixController@pagesButtons')->name('matrix.pages.buttons');
SimpleRouter::get('/matrix/pages/elements', 'MatrixController@pagesElements')->name('matrix.pages.elements');
SimpleRouter::get('/matrix/pages/gallery', 'MatrixController@pagesGallery')->name('matrix.pages.gallery');
SimpleRouter::get('/matrix/pages/calendar', 'MatrixController@pagesCalendar')->name('matrix.pages.calendar');
SimpleRouter::get('/matrix/pages/invoice', 'MatrixController@pagesInvoice')->name('matrix.pages.invoice');
SimpleRouter::get('/matrix/pages/chat', 'MatrixController@pagesChat')->name('matrix.pages.chat');

SimpleRouter::get('/matrix/error/404', 'MatrixController@error404')->name('matrix.error.404');



// HTTP Errors
SimpleRouter::error(function(Request $request, \Exception $exception) {
    
    // Render custom 404-page
    if($exception instanceof NotFoundHttpException && $exception->getCode() === 404) {
        $request->setRewriteCallback('ErrorController@http404');
        return;
    }
    
    // TODO: Other HTTP verbs ...
});