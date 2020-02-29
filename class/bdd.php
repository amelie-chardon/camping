<?php

class bdd{

    protected $connexion = "";

    public function connect(){
        $connect = mysqli_connect('localhost', 'root', '','camping');
        //var_dump($connect);
        if($connect == false){
            return false;
        }
        $this->connexion = $connect;
    }


    public function close(){
        mysqli_close($this->connexion);
    }
}

?>