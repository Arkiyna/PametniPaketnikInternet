<?php
require_once ("connection.php");

class Logs {

    public $id;
    public $userId;
    public $paketnikId;
    public $date;

    public function __construct($userId, $paketnikId, $date="", $id = 0) {
        $this->id = $id;
        $this->userId = $userId;
        $this->paketnikId = $paketnikId;
        $this->date = $date;
    }

    public function dodaj() {
        date_default_timezone_set('Europe/Ljubljana');

        $db = Db::getInstance();
        $userId = $this->userId;
        $paketnikId = $this->paketnikId;
        $date = Date('Y-m-d H:i:s');

        mysqli_query($db, "INSERT INTO Logs VALUES (NULL, '$userId', '$paketnikId', '$date')");

        if(mysqli_error($db)) {
            var_dump($db);
            exit();
        }

        $this->id=mysqli_insert_id($db);
    }

    public static function zgodovinaOdklepov($userId, $paketnikId) {
        date_default_timezone_set('Europe/Ljubljana');

        $db = Db::getInstance();
        $odklepi = array();

        if($result = mysqli_query($db, "SELECT * FROM Logs WHERE userId='$userId' AND paketnikId='$paketnikId'")) {
            while ($row = $result->fetch_assoc()) {
                $odklep = new Logs($row["userId"], $row["paketnikId"], $row["date"], $row["id"]);
                array_push($odklepi, $odklep);
            }
        }
        return $odklepi;
    }
}