<?php

class user_controller {


    public function registracija() {
        require_once('views/uporabnik/registracija.php');
    }

    public function shrani() {
        if($_POST["username"]!=""&&$_POST["password"]!=""&&$_POST["email"]!=""&&$_POST["birthDate"]!="") {
            $url = 'https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/user/register';
            $data = array('username' => $_POST["username"], 'password' => $_POST["password"], 'email' => $_POST["email"], 'birthDate' => $_POST["birthDate"]);

            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result === FALSE) {
                die();
            }
            require_once('views/uporabnik/prijava.php');
        }
        else{
            echo "Registracijski podatki niso ustrezno izpolnjeni";
        }
    }

    public function prijava(){
        if(isset($_POST["username"]) && isset($_POST["password"])){

            $url = 'https://rain1.000webhostapp.com/PametniPaketnikInternet/api.php/user/login';
            $data = array('username' => $_POST["username"], 'password' => $_POST["password"]);

            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result === FALSE) {
                die();
            }

            $obj = json_decode($result);
            print $obj->{'id'};


            var_dump($result);


            $uporabnik = new User($obj->{"id"}, $obj->{"username"}, $obj->{"email"}, $obj->{"id"});
            if($uporabnik){
                $_SESSION["USER_ID"] = $uporabnik->id;
                $_SESSION["USER"] = $uporabnik;
                header("Location: index.php");
            }else{
                require_once('views/uporabnik/prijava.php');
            }
        }else{
            require_once('views/uporabnik/prijava.php');
        }
    }

    public function odjava() {
        session_unset(); //Odstrani sejne spremenljivke
        session_destroy(); //Uniči sejo
        header("Location: index.php"); //Preusmeri na index.php
    }
}
?>