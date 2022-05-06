<?php

class Db {
    private static $instance  = NULL;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = mysqli_connect("sql11.freemysqlhosting.net", "sql11490293", "CDixW1yCES", "sql11490293");
        }
        return self::$instance;
    }
}

?>