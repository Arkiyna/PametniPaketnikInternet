<?php
include "models/Logs.php";
include "models/User.php";
include "models/UserPaketnik.php";
include "models/Paketnik.php";

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
        case 'POST':
            parse_str(file_get_contents('php://input'), $input);
            if (isset($input) && isset($request[1]) && $request[1] == 'register' ) {
                $user = new User( $input["username"], $input["password"],$input["email"]);
                $user->dodaj();
            }
            else if (isset($input) && isset($request[1]) && $request[1] == 'login' ) {
                $user = User::login($input["username"],$input["password"]);
                echo json_encode($user);
            }
            else if (isset($input) && isset ($request[1]) && $request[1] == 'login_face') {
                $user = User::login_face($input["username"]);
                echo json_encode($user);
            }
    }
}

if(isset($request[0])&&($request[0]=='uporabnikPaketnik')) {
    switch ($method) {
        case 'DELETE':
            //http://localhost/PametniPaketnikInternet/api.php/uporabnikPaketnik/userId/paketnikId
            if(isset($request[1]) && isset($request[2])) {
                $userId = $request[1];
                $paketnikId = $request[2];
                UserPaketnik::izbrisi($userId, $paketnikId);

            }
            break;
        case 'POST':
            parse_str(file_get_contents('php://input'), $input);
            if(isset($input)) {
                if(isset($input["accessTill"]) && isset($input["username"])) {
                    $newUserId = UserPaketnik::getIdFromUsername($input["username"]);
                    if($newUserId != -1) {
                        $paketnik = new UserPaketnik($input["userId"], $input["paketnikId"], $input["name"], $input["accessTill"],0, 0, $newUserId);
                        $paketnik->dodaj();
                    }
                }
                else {
                    $paketnik = new UserPaketnik($input["userId"], $input["paketnikId"], $input["name"]);
                    $paketnik->dodaj();
                }
            }
        case 'GET':
            //https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/uporabnikPaketnik/dostop/userId/paketnikId
            if (isset($request[1]) && $request[1] == 'dostop') {
                $userId = $request[2];
                $paketnikId = $request[3];
                echo UserPaketnik::paketnik_exists($userId, $paketnikId);
            } else if ((isset($request[1]) && $request[1] == 'getAll')) {
                $userId = $request[2];
                $paketniki = UserPaketnik::getUsersPackets($userId);
                echo json_encode($paketniki);
            } else if((isset($request[1]) && $request[1] == 'getPaketnik')) {
                $id = $request[2];
                $paketnik = UserPaketnik::getPaketnik($id);
                echo json_encode($paketnik);
            } else if((isset($request[1]) && $request[1] == 'getPaketnikBorrowed')) {
                $paketnikId = $request[2];
                $paketniki = UserPaketnik::getPaketnikBorrowed($paketnikId);
                echo json_encode($paketniki);
            } else if ((isset($request[1]) && $request[1] == 'izbrisi')) { //https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/uporabnikPaketnik/izbrisi/userId/paketnikId
                if(isset($request[1]) && isset($request[2])) {
                    $userId = $request[2];
                    $paketnikId = $request[3];
                    UserPaketnik::izbrisi($userId, $paketnikId);
                }
            } else if ((isset($request[1]) && $request[1] == 'spremeniIme')) { //https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/uporabnikPaketnik/spremeniIme/userId/paketnikId/name
                if(isset($request[2]) && isset($request[3])&& isset($request[4])) {
                    $userId = $request[2];
                    $paketnikId = $request[3];
                    $name = $request[4];
                    UserPaketnik::spremeniIme($userId, $paketnikId, $name);
                }
                break;
            }
    }
}

if(isset($request[0])&&($request[0]=='paketnik')) {
    switch ($method) {
        case 'DELETE':
            //http://localhost/PametniPaketnikInternet/api.php/paketnik/paketnikId
            if(isset($request[1])) {
                $paketnikId = $request[1];
                Paketnik::izbrisi($paketnikId);
            }
            break;
        case 'POST':
            parse_str(file_get_contents('php://input'), $input);
            if(isset($input)) {
                $paketnik = new Paketnik($input["paketnikId"]);
                $paketnik->dodaj();
            }
        case 'GET':
            //http://localhost/PametniPaketnikInternet/api.php/paketnik/izbrisi/paketnikId
            if(isset($request[1]) && $request[1] == 'izbrisi') {
                $paketnikId = $request[2];
                Paketnik::izbrisi($paketnikId);
            }
            break;
    }
}


//nastavimo glave odgovora tako, da brskalniku sporočimo, da mu vračamo json
//header('Content-Type: application/json');
//omgočimo zahtevo iz različnih domen
//header("Access-Control-Allow-Origin: *");
//izpišemo oglas, ki smo ga prej ustrezno nastavili