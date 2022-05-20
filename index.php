<?php
include_once('glava.php');
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else {

    $controller = 'oglas';
    $action = 'prikaziVse';
}

require_once('views/layout.php');
include_once('noga.php');