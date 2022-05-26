<?php

class UserPaketnik_controller
{
    public function prikaziVse() {
        $id = $_SESSION["USER_ID"];
        $api_url = "https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/uporabnikPaketnik/getAll/$id";
        // Read JSON file
        $json_data = file_get_contents($api_url);

        // Decode JSON data into PHP array
        $response_data = json_decode($json_data);

        echo "<h2>Moji paketniki</h2>";
        echo '<div style="margin: 0 20px">';

        foreach ($response_data as $data) {
            echo "<h3> $data->name </h3>";
            echo '<div style="margin: 0 20px">';
            echo "<p>ID paketnika: $data->paketnikId</p>";
            if($data->isOwner == "1") {
                echo "<p>Lastnik paketnika</p>";
            }
            else {
                echo "<p>Paketnik v posoji</p>";
            }
            if ($data->accessTill == "9999-12-31 23:59:59") {
                echo "<p>Neomejen dostop</p>";
            }
            else {
                $date = new DateTime($data->accessTill);
                echo "<p>Dostop do: " . date_format($date, 'd.m.Y H:i:s') . "</p>";
            }
            echo "<a href='index.php?controller=userPaketnik&action=prikaziPaketnik&id=$data->id'><button class='btn btn-primary'>Upravljaj s paketnikom</button></a>";
            echo "<br /> <br />";
            echo "</div>";
        }
        echo "</div>";
    }

    public function prikaziPaketnik() {
        if (!isset($_GET['id'])) {
            return call('strani', 'napaka');
        }
        $id = $_GET['id'];
        $api_url = "https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/uporabnikPaketnik/getPaketnik/$id";

        // Read JSON file
        $json_data = file_get_contents($api_url);
        // Decode JSON data into PHP array
        $paketnik = json_decode($json_data);
        $userId = $paketnik->userId;
        $paketnikId = $paketnik->paketnikId;

        $api_url = "https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/logs/zgodovinaOdklepov/$userId/$paketnikId";
        $json_data = file_get_contents($api_url);
        $zgodovina = json_decode($json_data);

        $api_url = "https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/logs/zgodovinaOdklepov/$userId/$paketnikId";
        $json_data = file_get_contents($api_url);
        $zgodovina = json_decode($json_data);


        $api_url = "https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/uporabnikPaketnik/getPaketnikBorrowed/$paketnikId";
        $json_data = file_get_contents($api_url);
        $borrowed = json_decode($json_data);
        require_once('views/userPaketnik/prikaziPaketnik.php');
    }
    public function dodajPaketnikView(){
        require_once('views/userPaketnik/dodajPaketnik.php');
    }
    public function dodajPaketnik(){
        $userId = $_SESSION["USER_ID"];
        if($_POST["paketnikId"]!=""&&$_POST["nickname"]!="") {

            $url = 'https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/uporabnikPaketnik';
            $data = array('userId' => $userId, 'paketnikId' => $_POST["paketnikId"], 'name' => $_POST["nickname"]);
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            if ($result == '"Ta paketnik ze ima lastnika!"') {
                echo '<div class="alert alert-danger alert-dismissible">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          Ta paketnik že ima lastnika
                      </div>';
                $this->dodajPaketnikView();
                die();
            }
            else if ($result == '"Uporabnik ze ima paketnik!"') {
                echo '<div class="alert alert-danger alert-dismissible">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          Uporabnik že ima paketnik
                      </div>';
                $this->dodajPaketnikView();
                die();
            }

            if ($result === FALSE) {
                die();
            }
            //$this->prikaziVse();
        }
        else{
            echo "Registracijski podatki niso ustrezno izpolnjeni";
        }
    }

    public function posodiKljuc() {
        $userId = $_SESSION["USER_ID"];
        $paketnikId = $_POST["redirectId"];
        if($_POST["paketnikId"] != "" && $_POST["username"] != "" && $_POST["accessTill"] != "") {
            $url = 'https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/uporabnikPaketnik';
            $data = array('userId' => $userId, 'paketnikId' => $_POST["paketnikId"], 'name' => $_POST["name"], 'accessTill' => $_POST["accessTill"], 'username' => $_POST["username"]);
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result === FALSE) {
                die();
            }
            header('Location: '. "index.php?controller=userPaketnik&action=prikaziPaketnik&id=$paketnikId");

        }
        else{
            echo "Napaka";
        }
    }
}