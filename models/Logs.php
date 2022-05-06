<?php
require_once ("connection.php");

class Logs {

    public $id;
    public $userId;
    public $paketnikId;
    public $date;
    public function __construct($id, $userId, $paketnikId, $date) {
        $this->id = $id;
        $this->userId = $userId;
        $this->paketnikId = $paketnikId;
        $this->date = $date;
    }

    public static function zgodovinaOdklepov($userId, $paketnikId) {
        $db = Db::getInstance();
        $odklepi = array();

        if($result = mysqli_query($db, "SELECT * FROM Logs WHERE userId='$userId' AND paketnikId='$paketnikId'")) {
            while ($row = $result->fetch_assoc()) {
                $odklep = new Logs($row["id"], $row["userId"], $row["paketnikId"], $row["date"]);
                array_push($odklepi, $odklep);
            }
        }
        return $odklepi;
    }
}