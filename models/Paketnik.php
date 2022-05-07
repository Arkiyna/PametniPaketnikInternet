<?php

class Paketnik
{
    public $id;
    public $paketnikId;

    public function __construct($paketnikId,$id=0) {
        $this->id = $id;
        $this->paketnikId = $paketnikId;
    }

    public static function izbrisi($paketnikId) {
        $db = Db::getInstance();

        if(mysqli_query($db, "DELETE FROM Paketnik WHERE paketnikId = '$paketnikId'")) {
            echo "Paketnik z ID-jem '$paketnikId' uspešno izbrisan";
        }
        else {
            echo "Napaka";
        }
    }
}