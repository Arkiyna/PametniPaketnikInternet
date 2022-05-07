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

    public static function izbrisi($userId, $paketnikId) {
        $db = Db::getInstance();

        if(mysqli_query($db, "DELETE FROM User_Paketnik WHERE userId = '$userId' AND paketnikId = '$paketnikId'")) {
            echo "Paketnik z ID-jem '$paketnikId' uspešno izbrisan";
        }
        else {
            echo "Napaka";
        }
    }
}