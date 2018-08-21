<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/helperfns.php';
require_once __DIR__ . '/../lib/routehelper.php';
require_once __DIR__ . '/routes.php';

use Tracy\Debugger;
use Pecee\SimpleRouter\SimpleRouter;

// Debug
Debugger::enable();

// Router
SimpleRouter::start();
