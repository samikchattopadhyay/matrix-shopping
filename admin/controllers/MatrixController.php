<?php 

class MatrixController {
    
    public function dashboard() {
        return view('matrix.dashboard', []);
    }
    
    public function charts() {
        return view('matrix.charts', []);
    }
    
    public function widgets() {
        return view('matrix.widgets', []);
    }
    
    public function tables() {
        return view('matrix.tables', []);
    }
    
    public function grid() {
        return view('matrix.grid', []);
    }
    
    public function formBasic() {
        return view('matrix.form.basic', []);
    }
    
    public function formWizard() {
        return view('matrix.form.wizard', []);
    }
    
    public function pagesButtons() {
        return view('matrix.pages.buttons', []);
    }
    
    public function iconMaterial() {
        return view('matrix.icon.material', []);
    }
    
    public function iconFontawesome() {
        return view('matrix.icon.fontawesome', []);
    }
    
    public function pagesElements() {
        return view('matrix.pages.elements', []);
    }
    
    public function pagesGallery() {
        return view('matrix.pages.gallery', []);
    }
    
    public function pagesCalendar() {
        return view('matrix.pages.calendar', []);
    }
    
    public function pagesInvoice() {
        return view('matrix.pages.invoice', []);
    }
    
    public function pagesChat() {
        return view('matrix.pages.chat', []);
    }
    
    public function error404() {
        return view('matrix.errors.404', []);
    }
}
