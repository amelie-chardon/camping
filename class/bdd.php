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

    public function delete()
    {
        
        if (!isset($_SESSION))
        {
           echo "Impossible de supprimer. Veuillez d'abord vous connecter.";
        }
        else
        {
            $connect = mysqli_connect("localhost", "root", "", "camping");
            $delete="DELETE FROM reservations WHERE id = '".$_POST['resat']."'";
            $query=mysqli_query($connect,$delete);
            unset($_SESSION['login']);
            echo "La réservation a bien été supprimer";
        }
    }

    public function update($id)
    {
        $connect = mysqli_connect("localhost", "root", "", "camping");
        $update="UPDATE prix SET prix = ".$_POST[$id]." WHERE id = $id";
        $query_update=mysqli_query($connect,$update);
        echo "le prix a bien été modifier.";
    }
}    
?>