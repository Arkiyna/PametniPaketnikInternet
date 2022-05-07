<?php
include "models/Logs.php";
include "models/User.php";
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
                echo json_encode($logs);
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
if(isset($request[0])&&($request[0]=='user')){
    switch ($method) {
        case 'GET':
            if (isset($request[1]) && $request[1] == 'login') {
                $userId = $request[2];
                $paketnikId = $request[3];
                $logs = Logs::zgodovinaOdklepov($userId, $paketnikId);
            }
        case 'POST':
            parse_str(file_get_contents('php://input'), $input);
            if (isset($input) && isset($request[1]) && $request[1] == 'register' ) {
                $user = new User( $input["username"], $input["password"],$input["email"]);
                $user->dodaj();
            }
            if (isset($input) && isset($request[1]) && $request[1] == 'login' ) {

                $user = User::login($input["username"],$input["password"]);
                echo json_encode($user);
            }
    }
}

//nastavimo glave odgovora tako, da brskalniku sporočimo, da mu vračamo json
header('Content-Type: application/json');
//omgočimo zahtevo iz različnih domen
header("Access-Control-Allow-Origin: *");
//izpišemo oglas, ki smo ga prej ustrezno nastavili

