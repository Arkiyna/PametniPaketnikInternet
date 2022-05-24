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

        foreach ($response_data as $data) {
            echo "<h3> $data->name </h3>";
            echo "<p>ID paketnika: $data->paketnikId</p>";
            echo "<p>Dostop do: $data->accessTill</p>";
            echo "<a href='index.php?controller=userPaketnik&action=prikaziPaketnik&id=$data->id'><button>Preberi več</button></a>";
            echo "<br /> <br />";
        }
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
        require_once('views/userPaketnik/prikaziPaketnik.php');
    }
}