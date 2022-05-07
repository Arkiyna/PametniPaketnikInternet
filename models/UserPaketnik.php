<?php

class UserPaketnik
{
    public $id;
    public $userId;
    public $paketnikId;
    public $name;

    public function __construct($userId, $paketnikId, $name, $id=0) {
        $this->id = $id;
        $this->userId = $userId;
        $this->paketnikId = $paketnikId;
        $this->name = $name;
    }
    function paketnik_exists($userId,$paketnikId){
        $db = Db::getInstance();

        $query = "SELECT * FROM User_Paketnik WHERE userId='$userId' AND paketnikId = '$paketnikId'";
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
    public function dodaj() {

        $userId = $this->userId;
        $paketnikId = $this->paketnikId;
        $name = $this->name;
        if($this->paketnik_exists($userId,$paketnikId)){
            echo json_encode("Uporabnik ze ima paketnik!");
        }
        else {
            $db = Db::getInstance();
            mysqli_query($db, "INSERT INTO User_Paketnik VALUES (NULL, '$userId', '$paketnikId', '$name')");

            if (mysqli_error($db)) {
                var_dump($db);
                exit();
            }

            $this->id = mysqli_insert_id($db);
        }
    }
}