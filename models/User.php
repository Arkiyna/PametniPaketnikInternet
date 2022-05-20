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
    function username_exists($username){
        $db = Db::getInstance();

        $query = "SELECT * FROM User WHERE username='$username'";
        $res = $db->query($query);
        return mysqli_num_rows($res) > 0;
    }
    public function dodaj(){
        $username = $this->username;
        $password = sha1($this->password);
        $email = $this->email;
        if($this->username_exists($username)){
            echo json_encode("Zaseden username");
        }
        else {
            $db = Db::getInstance();


            mysqli_query($db, "INSERT INTO User VALUES (NULL, '$username', '$password', '$email')");

            if (mysqli_error($db)) {
                var_dump($db);
                exit();
            }

            $this->id = mysqli_insert_id($db);
        }
    }
    public static function login($username,$password) {
        $password=sha1($password);
        $db = Db::getInstance();

        if($result = mysqli_query($db, "SELECT * FROM User WHERE username='$username' AND password='$password'")) {
            while ($row = $result->fetch_assoc()) {
                $user = new User($row["username"], $row["password"], $row["email"], $row["id"]);
                return $user;
            }
        }

    }
}