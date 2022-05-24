<?php
include_once('glava.php');
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
}
else {
    if (isset($_SESSION["USER_ID"])) {
        $controller = 'userPaketnik';
        $action = 'prikaziVse';
    } else {
        $controller = 'user';
        $action = 'prijava';
    }
}
require_once('views/layout.php');
include_once('noga.php');