<?php

class bdd
{

    private $query="";
    protected $connexion = "";
    private $result=[];


    public function connect()
    {
        $connect = mysqli_connect('localhost', 'root', '','camping');
        //var_dump($connect);
        if($connect == false)
        {
            return false;
        }
        $this->connexion = $connect;
    }


    public function close(){
        mysqli_close($this->connexion);
    }


    public function execute($query)
    { 
        {
            $this->query=$query;
            $execute=mysqli_query($this->connexion, $query);

            // Si le résultat est un booléen 
            if(is_bool($execute))
            {
                $this->result=$execute;
            }
            // Si le résultat est un tableau
            else
            {
                $this->result=mysqli_fetch_all($execute);
            }

            return $this->result;
        }
    }

    //Fonctions pour màj bdd

    public function delete_resa()
    { 
        if (!isset($_SESSION))
        {
            echo "Impossible de supprimer. Veuillez d'abord vous connecter.";
        }
        else
        {
            $this->connect();
            $this->execute("DELETE FROM reservations WHERE id = '".$_POST['resat']."'");
            $this->close();
        }
    }
    
    public function update_prix($id)
    {
        $this->connect();
        $this->execute("UPDATE prix SET prix = ".$_POST[$id]." WHERE id = $id");
        $this->close();
    }
}  
?>