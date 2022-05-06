<?php

class User
{
    public $id;
    public $username;
    public $password;
    public $email;

    public function __construct($username, $password, $email,$id=0) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }
    public function dodaj(){
        $db = Db::getInstance();
        $username = $this->username;
        $password = sha1($this->password);
        $email = $this->email;

        mysqli_query($db, "INSERT INTO User VALUES (NULL, '$username', '$password', '$email')");

        if(mysqli_error($db)) {
            var_dump($db);
            exit();
        }

        $this->id=mysqli_insert_id($db);
    }
}