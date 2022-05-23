<?php

class UserPaketnik {
    public $id;
    public $userId;
    public $paketnikId;
    public $name;
    public $isOwner;
    public $accessTill;
    public $newUserId;

    public function __construct($userId, $paketnikId, $name, $accessTill='', $isOwner=0, $id=0, $newUserId=-1) {
        $this->id = $id;
        $this->userId = $userId;
        $this->paketnikId = $paketnikId;
        $this->name = $name;
        $this->newUserId = $newUserId;
        $this->isOwner = $isOwner;
        $this->accessTill = $accessTill;
    }
    public static function paketnik_exists($userId,$paketnikId){
        $db = Db::getInstance();

        date_default_timezone_set('Europe/Ljubljana');

        $date = Date('Y-m-d H:i:s');
        $query = "SELECT * FROM User_Paketnik WHERE userId='$userId' AND paketnikId = '$paketnikId' AND accessTil > '$date'";
        $res = $db->query($query);
        return mysqli_num_rows($res) > 0;
    }

    function isPaketnikOwner($userId, $paketnikId) {
        $db = Db::getInstance();

        $query = "SELECT * FROM User_Paketnik WHERE userId='$userId' AND paketnikId = '$paketnikId' and isOwner is TRUE";
        $res = $db->query($query);
        return mysqli_num_rows($res) > 0;
    }

    function paketnik_has_owner($paketnikId) {
        $db = Db::getInstance();

        $query = "SELECT * FROM User_Paketnik WHERE paketnikId = '$paketnikId' and isOwner is TRUE";
        $res = $db->query($query);
        return mysqli_num_rows($res) > 0;
    }

    public static function izbrisi($userId, $paketnikId) {
        $db = Db::getInstance();

        if(mysqli_query($db, "DELETE FROM User_Paketnik WHERE userId = '$userId' AND paketnikId = '$paketnikId'")) {
            echo "Paketnik z ID-jem '$paketnikId' uspešno izbrisan";
        }
        else {
            echo "Napaka";
        }
    }

    public function getUsersPackets($userId) {
        $db = Db::getInstance();

        $paketniki = array();

        if($result = mysqli_query($db, "SELECT * FROM User_Paketnik WHERE userId='$userId'")) {
            while ($row = $result->fetch_assoc()) {
                $paketnik = new UserPaketnik($row["userId"], $row["paketnikId"], $row["name"],$row["accessTil"], $row["isOwner"], $row["id"]);
                array_push($paketniki, $paketnik);
            }
        }
        return $paketniki;
    }

    public function dodaj() {
        $userId = $this->userId;
        $paketnikId = $this->paketnikId;
        $name = $this->name;
        if($this->newUserId != -1) {
            if($this->isPaketnikOwner($userId, $paketnikId)) {
                $isOwner = 0;
                $accessTill = $this->accessTill;
                $userId = $this->newUserId;
            }
            else {
                echo json_encode("Uporabnik ni lastnik paketnika!");
                exit();
            }
        }
        else {
            echo $this->newUserId;
            if($this->paketnik_has_owner($paketnikId)) {
                echo json_encode("Ta paketnik ze ima lastnika!");
                exit();
            }
            $isOwner = 1;
            $accessTill = '9999-12-31 23:59:59';
        }
        if($this->paketnik_exists($userId,$paketnikId)){
            echo json_encode("Uporabnik ze ima paketnik!");
        }
        else {
            $db = Db::getInstance();
            mysqli_query($db, "INSERT INTO User_Paketnik VALUES (NULL, '$userId', '$paketnikId', '$name', '$isOwner', '$accessTill')");

            if (mysqli_error($db)) {
                var_dump($db);
                exit();
            }

            $this->id = mysqli_insert_id($db);
        }
    }

    public static function spremeniIme($userId, $paketnikId, $name) {
        $db = Db::getInstance();

        if(mysqli_query($db, "UPDATE User_Paketnik SET name = $name WHERE userId = '$userId' AND paketnikId = '$paketnikId'")) {
            echo "Paketnik z ID-jem '$paketnikId' je bil uspešno preimenovan";
        }
        else {
            echo "Napaka";
        }
    }
}