<?php 
require 'class/bdd.php';
require 'class/user.php';
require 'class/reservation.php';



session_start();

if(!isset($_SESSION['bdd']))
{
    $_SESSION['bdd'] = new bdd();
}
if(!isset($_SESSION['user'])){
    $_SESSION['user'] = new user();
}
if($_SESSION['user']->isConnected() != true){
    header('Location:index.php');
}?>
<html>

<head>
        <title>Profil</title> 
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Leckerli+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>

<?php require 'header.php'?>

<?php 
$_SESSION['bdd']->connect();
$reservations=$_SESSION['bdd']->execute("SELECT * FROM reservations where id_utilisateur=12");
for($i=0;$i<count($reservations);$i++)
{
    $reservation[$i]=new reservation();
    $reservation[$i]->setDate($reservations[$i][1],$reservations[$i][2]);
    $reservation[$i]->setEmplacement($reservations[$i][5]);
    $reservation[$i]->setEquipement($reservations[$i][6]);
    $reservation[$i]->setNbEmplacements();
    $reservation[$i]->setOptions($reservations[$i][7],$reservations[$i][8],$reservations[$i][9]);
    $reservation[$i]->setPrix($reservations[$i][10]);

    //echo $reservation[$i]->getDateArrivee("str");
}
    echo $reservation[1]->getDateDepart("str");
    echo $reservation[1]->getDateArrivee("str");
    echo $reservation[1]->getEmplacement("str");
    echo $reservation[1]->getEquipement("str");
    echo $reservation[1]->getBorne("str");
    echo $reservation[1]->getClub("str");
    echo $reservation[1]->getActivites("str");
    echo $reservation[1]->getPrix("str");









?>

<main>
<section>
    <h1> Mon compte </h1>
            <form action="profil.php" class="formulaire" method="post">
                <label>Login</label>
                <input type="text" name="login" required><br>
                <label>Mail</label>
                <input type="mail" name="mail" required><br>
                <label>Password</label>
                <input type="password" name="password" minlength="12"required ><br>
                <label>Password confirm</label>
                <input type="password" name="passwordconf" minlength="12" required><br>
                
                <input type="submit" name="send">
                </form> 
            
 
        </section>

<?php
if(isset($_POST["send"])){
    if(!empty($_POST["passwordconf"])){
        if(!empty($_POST["login"])){
            $_SESSION['user']->profil($_POST["passwordconf"],$_POST["login"],NULL,NULL,NULL,NULL);
        }
        if(!empty($_POST["mail"])){
            $_SESSION['user']->profil($_POST["passwordconf"],NULL,NULL,NULL,$_POST["mail"],NULL);
        }
        if(!empty($_POST["password"])){
            $_SESSION['user']->profil($_POST["passwordconf"],NULL,NULL,NULL,NULL,$_POST["password"]);
        }
    }
    else{
        ?>
            <p>Veuillez rentrer votre ancien mot de passe pour valider vos changements.</p>
        <?php
    }
}

?>

</main>

<?php require 'footer.php'?>


</body>

</html>