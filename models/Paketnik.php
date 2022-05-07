<?php

class Paketnik
{
    public $id;
    public $paketnikId;

    public function __construct($paketnikId,$id=0) {
        $this->id = $id;
        $this->paketnikId = $paketnikId;
    }
    function paketnik_exists($paketnikId){
        $db = Db::getInstance();

        $query = "SELECT * FROM Paketnik WHERE paketnikId = '$paketnikId'";
        $res = $db->query($query);
        return mysqli_num_rows($res) > 0;
    }
    public function dodaj() {

        $paketnikId = $this->paketnikId;
        if($this->paketnik_exists($paketnikId)){
            echo json_encode("Paketnik je ze v bazi!");
        }
        else {
            $db = Db::getInstance();
            mysqli_query($db, "INSERT INTO Paketnik VALUES (NULL,'$paketnikId')");

            if (mysqli_error($db)) {
                var_dump($db);
                exit();
            }

            $this->id = mysqli_insert_id($db);
        }
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