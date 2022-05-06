<?php
include "models/Logs.php";

$method = $_SERVER["REQUEST_METHOD"];

if(isset($_SERVER['PATH_INFO']))
    $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

else
    $request="";

$db = Db::getInstance();

if(isset($request[0])&&($request[0]=='logs')) {
    switch ($method) {
        case 'GET':
            //vrni oglas
            if (isset($request[1]) && $request[1] == 'zgodovinaOdklepov') {
                $userId = $request[2];
                $paketnikId = $request[3];
                $logs = Logs::zgodovinaOdklepov($userId, $paketnikId);
            }
            break;
        case 'POST':
            parse_str(file_get_contents('php://input'), $input);
            if (isset($input)) {
                $logs = new Logs($input["userId"], $input["paketnikId"]);
                $logs->dodaj();
            }

    }
}

//nastavimo glave odgovora tako, da brskalniku sporočimo, da mu vračamo json
header('Content-Type: application/json');
//omgočimo zahtevo iz različnih domen
header("Access-Control-Allow-Origin: *");
//izpišemo oglas, ki smo ga prej ustrezno nastavili
echo json_encode($logs);