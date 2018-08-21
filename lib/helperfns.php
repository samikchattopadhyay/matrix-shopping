<?php 

use Jenssegers\Blade\Blade;
use Aura\Session\SessionFactory;

function t($a, $e = false) {
    echo '<pre style="background-color: #ebebeb; border: 1px #bcbdbe solid; padding: 10px;">' . print_r($a, true) . '</pre>';
    if ($e) exit;
}

function view($viewName, $params) {
    
    $blade = new Blade('views', 'cache');
    
    $blade->compiler()->directive('datetime', function ($expression) {
        return "<?php echo with({$expression})->format('F d, Y g:i a'); ?>";
    });
    
    return $blade->make($viewName, $params);
    
}

function session($segment = 'DEFAULT') {
    
    global $session;
    
    if ($session == null) {
        $sessionFactory = new SessionFactory();
        $session = $sessionFactory->newInstance($_COOKIE);
    }
    
    if ($segment === true) {
        return $session;
    }
    
    return $session->getSegment($segment);
}


function logErrors($error, $type, $info) {
    
    $db = Database::singleton();
    $database = $db->Connection();
    
    $data = array(
        'error' => $error,
        'type' => $type,
        'info' => print_r($info, true)
    );
    
    try {
        $database->query('INSERT INTO errors ?', $data);
        return $database->getInsertId();
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

