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
if(!isset($_SESSION['reservation'])){
    $_SESSION['reservation'] = new reservation();
}
if($_SESSION['user']->isConnected() != true){
    header('Location:index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="html/css; charset=utf-8" />
        <title>Formulaire de réservation</title> 
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Leckerli+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    </head>

<body class="body1">

<?php require 'header.php'?>


<main>
<section class="tout-formulaire">
    <h1 class="modifier"> Formulaire de réservation</h1>

<?php 

//PAGE 1 : CHOIX DES DATES

if(!isset($_GET["etape"])){

    $date_actuelle=date("Y-m-d", time());

    ?>

    <form class="formulaire" action="reservation-form.php?etape=2" method="get">
    <label><p class="date">Date d'arrivée</p></label>
    <input type="date" name="date_debut" class="les-dates" min="<?php echo date("d/m/Y", time()) ?>" required/>
    <label><p class="date">Date de départ</p></label>
    <input type="date" name="date_fin" class="les-dates" min="<?php echo date("d/m/Y", time()+24*3600) ?>"required/>
    <input type="hidden" name="etape" value="1">
    <input type="submit" name="submit" value="Valider">
    </form>
    <?php

    if(isset($_GET["date_debut"]))
    {
        $date_debut=$_GET["date_debut"];
        $date_fin=$_GET["date_fin"];
        $_SESSION["reservation"]->setDateArrivee($_GET['date_debut']);

        //Verification que la date de départ est postérieure à la date d'arrivée
        if(strtotime($_GET["date_fin"])<=strtotime($_GET["date_debut"]))
        {
            ?>
            <form class="formulaire" action="reservation-form.php?etape=2" method="get">
            <label>Date d'arrivée</label>
            <input type="date" name="date_debut" min="<?php echo date("d/m/Y", time()) ?>" required/>
            <label>Date de départ</label>
            <input type="date" name="date_fin" min="<?php echo date("d/m/Y", time()+24*3600) ?>" required/>
            <input type="hidden" name="etape" value="1">
            <input type="submit" name="submit" value="Valider">
            </form>
            <p class='inscription-error'>Veuillez choisir une date de départ postérieure à la date d'arrivée.</p>
            <?php
        }
    }
}
//PAGE 2 : CHOIX DES EQUIPEMENTS/OPTIONS

elseif($_GET["etape"]==1)
{
    $_SESSION["reservation"]->setDate($_GET['date_debut'],$_GET['date_fin']);
    $date_arrivee=$_SESSION["reservation"]->getDateArrivee("str");
    $date_depart=$_SESSION["reservation"]->getDateDepart("str");
    ?>
    <p class="date">Date d'arrivée : <?php echo $date_arrivee;?></p>
    <p class="date">Date de départ : <?php echo $date_depart; ?></p>
    <?php


        //Récupération des équipements sur la BDD
        $_SESSION['bdd']->connect();
        $equipements=$_SESSION['bdd']->execute("SELECT * FROM equipements INNER JOIN prix ON prix.nom=equipements.nom");
        $options=$_SESSION['bdd']->execute("SELECT * FROM options INNER JOIN prix ON prix.nom=options.nom");
        $_SESSION['bdd']->close();
        ?>
    
        <form class="formulaire" action="reservation-form.php?etape=3" method="get">
        <label><h1 class="modifier">Votre équipement</h1></label>
        <select name="Equipement" required/>
                    <option value="" class="largeur">Equipement</option>
                    <?php 
                    foreach($equipements as $equipement)
                    {
                        ?>
                        <option value="<?php echo $equipement[0]; ?>"><?php echo $equipement[1].' ('.$equipement[5].' €/jour)' ?></option>
                        <?php
                    }
                    ?>
        </select>
        <br/>
        <label><h1 class="modifier">Vos options</h1></label>
        <?php 
                    foreach($options as $option)
                    {
                        ?>
                        <input type="checkbox" value="1" class="checkbox" name="<?php echo $option[1]; ?>"><p class="date"><?php echo $option[2]; echo ' ('.$option[5].' €/jour)'; ?></p><br/>
                        <?php
                    }
                    ?>
        <br/>
        <input type="hidden" name="etape" value="2">
        <input type="submit" name="submit" value="Valider">
        </form>

<?php
}
//PAGE 1 : CHOIX DE L'EMPLACEMENT
elseif($_GET["etape"]==2)
{
    $date_arrivee=$_SESSION["reservation"]->getDateArrivee();
    $date_depart=$_SESSION["reservation"]->getDateDepart();
    $nb_emplacements=$_SESSION["reservation"]->setNbEmplacements();

    $_SESSION["reservation"]->setEquipement($_GET["Equipement"]);
    $equipement_str=$_SESSION["reservation"]->getEquipement("str");


    if(!isset($_GET["Borne"])) $borne=0; else $borne=1;
    if(!isset($_GET["Club"])) $club=0; else $club=1;
    if(!isset($_GET["Activites"])) $activites=0; else $activites=1;

    $_SESSION["reservation"]->setOptions($borne,$club,$activites);


    ?>
    <p class="date">Date d'arrivée : <?php echo $_SESSION["reservation"]->getDateArrivee("str");?></p>
    <p class="date">Date de départ : <?php echo $_SESSION["reservation"]->getDateDepart("str"); ?></p>
    <p class="date">Equipement : <?php echo $equipement_str; ?></p>
    <h1 class="modifier">Vos options : 
    <?php 
     echo $_SESSION["reservation"]->getBorne("str");
     echo $_SESSION["reservation"]->getClub("str") ;
     echo $_SESSION["reservation"]->getActivites("str");
     ?></h1>


    <?php
        //On vérifie les emplacements disponibles par lieu
        $_SESSION["reservation"]->connect();
        $empl_1=$_SESSION["reservation"]->execute("SELECT SUM(nb_emplacement) FROM reservations WHERE id_emplacement=1 AND (debut OR fin BETWEEN \"$date_arrivee\" AND \"$date_depart\")");
        $empl_2=$_SESSION["reservation"]->execute("SELECT SUM(nb_emplacement) FROM reservations WHERE id_emplacement=2 AND (debut OR fin BETWEEN \"$date_arrivee\" AND \"$date_depart\")");
        $empl_3=$_SESSION["reservation"]->execute("SELECT SUM(nb_emplacement) FROM reservations WHERE id_emplacement=3 AND (debut OR fin BETWEEN \"$date_arrivee\" AND \"$date_depart\")");

        //On définit le nombre total d'emplacements disponibles par lieu
        $total_emplacements=4;

        //On calcule le nombre d'emplacements libres par lieu
        $empl_libres_1=$total_emplacements-intval($empl_1[0][0]);
        $empl_libres_2=$total_emplacements-intval($empl_2[0][0]);
        $empl_libres_3=$total_emplacements-intval($empl_3[0][0]);
        $empl_libres=array($empl_libres_1,$empl_libres_2,$empl_libres_3);

        //Récupération du nombre d'emplacements de la réservation
        $nb_emplacements=$_SESSION["reservation"]->getNbEmplacements();

        //Récupération des emplacements sur la BDD
        $_SESSION['bdd']->connect();
        $emplacements=$_SESSION['bdd']->execute("SELECT * FROM emplacements");
        $_SESSION['bdd']->close();

        ?>
    
        <form class="formulaire" action="reservation-form.php?etape=3" method="get">
        <select name="Emplacement" required/>
                    <option value="">Emplacement</option>
                    <?php
                    //On affiche "disabled" pour les lieux où il n'y a pas assez de place de libre
                    for($i=0;$i<3;$i++)
                    {
                        ?>
                        <option value="<?php echo $emplacements[$i][0]; ?>" <?php if($empl_libres[$i]<$nb_emplacements) echo "disabled"; ?> ><?php echo $emplacements[$i][1] ; ?></option>
                        <?php
                    }
                    ?>
        </select>
        <input type="hidden" name="etape" value="3">
        <input type="submit" name="submit" value="Valider">
        </form>
<?php
}
//PAGE 4 : RECAPITULATIF + ENVOI RESERVATION
elseif($_GET["etape"]==3)
{
    $_SESSION["reservation"]->setEmplacement($_GET['Emplacement']);

    $date_arrivee=$_SESSION["reservation"]->getDateArrivee();
    $date_depart=$_SESSION["reservation"]->getDateDepart();
    $date_arrivee_str=$_SESSION["reservation"]->getDateArrivee("str");
    $date_depart_str=$_SESSION["reservation"]->getDateDepart("str");
    $equipement=$_SESSION["reservation"]->getEquipement();
    $equipement_str=$_SESSION["reservation"]->getEquipement("str");
    $borne=$_SESSION["reservation"]->getBorne();
    $borne_str=$_SESSION["reservation"]->getBorne("str");
    $club_str=$_SESSION["reservation"]->getClub("str") ;
    $activites_str=$_SESSION["reservation"]->getACtivites("str");
    $club=$_SESSION["reservation"]->getClub();
    $activites=$_SESSION["reservation"]->getActivites(null);
    $emplacement=$_SESSION["reservation"]->getEmplacement();
    $emplacement_str=$_SESSION["reservation"]->getEmplacement("str");

    $_SESSION["reservation"]->setNbEmplacements();
    $nb_emplacements=$_SESSION["reservation"]->getNbEmplacements();
    $id_utilisateur=$_SESSION["user"]->getid();
    $_SESSION["reservation"]->setNbJours();

    $nb_jours=$_SESSION["reservation"]->getNbJours();
    $_SESSION["reservation"]->setPrix();
    $prix=$_SESSION["reservation"]->getPrix();

    //Affichage du récapitulatif de la réservation
    ?>
    <p class="date">Date d'arrivée : <?php echo $date_arrivee_str ;?></p>
    <p class="date">Date de départ : <?php echo $date_depart_str; ?></p>
    <p class="date">Equipement : <?php echo $equipement_str; ?></p>
    <h1 class="modifier">Vos options :</h1><p class="date"><?php echo $borne_str. $club_str.$activites_str; ?></p>
    <p class="date">Emplacement : <?php echo $emplacement_str ?></p>
    <p class="date">Prix : <?php echo $prix." €" ; ?></p>

    <form class="formulaire" method="POST">
    <input type="submit" name="submit" value="Valider la réservation">
    <input type="submit" name="submit" value="Modifier la réservation">
    </form>
    <?php

    if(isset($_POST["submit"]))
    {
        if($_POST["submit"]=="Valider la réservation")
        {
            //Enregistrement de la réservation dans la BDD
            $_SESSION["reservation"]->connect();
            $_SESSION["reservation"]->execute("INSERT INTO reservations (debut,fin,nb_jours,id_utilisateur,id_emplacement,nb_emplacement,id_borne,id_club,id_activites,prix) VALUES (\"$date_arrivee\",\"$date_depart\",\"$nb_jours\",\"$id_utilisateur\",\"$emplacement\",\"$nb_emplacements\",\"$borne\",\"$club\",\"$activites\",\"$prix\")");
            $_SESSION["reservation"]->close();
            //Retour vers la page profil
            header("location:profil.php");

        }
        if($_POST["submit"]=="Modifier la réservation")
        {
            //Retour à la page de réservation
            header("location:reservation-form.php");
        }
    }
}

?>
</section>

</main>

<?php require 'footer.php'?>


</body>

</html>