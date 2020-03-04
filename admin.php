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
if(!isset($_SESSION['role'])){
    header('Location:index.php');
}



?>
<html>

<head>
        <title>Administration</title> 
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Leckerli+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>

<?php require 'header.php'?>


<main>
<section>
    <h1> Administration du site </h1>
            


<?php
$_SESSION['bdd']->connect();
$price=$_SESSION['bdd']->execute("SELECT prix,nom FROM prix");
//var_dump($price);
$reservations=$_SESSION['bdd']->execute("SELECT * FROM reservations INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id WHERE `fin`> CURDATE()");
//var_dump($reservations);
$_SESSION['bdd']->close();

?>
<h2>Tableau des réservations en cours</h2>

<table>
<thead>
    <tr>
        <th>N°</th>
        <th>Client</th>
        <th>Date de début</th>
        <th>Date de fin</th>
        <th>Equipement</th>
        <th>Emplacement</th>
        <th>Options</th>
        <th>Prix</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
<?php

//Affichage des réservations
for($i=0;$i<count($reservations);$i++)
{
    $id_reservation[$i]=$reservations[$i][0];
    $login_reservation[$i]=$reservations[$i][12];
    $reservation[$i]=new reservation();
    $reservation[$i]->setDate($reservations[$i][1],$reservations[$i][2]);
    $reservation[$i]->setEmplacement($reservations[$i][5]);
    $reservation[$i]->setEquipement($reservations[$i][6]);
    $reservation[$i]->setNbEmplacements();
    $reservation[$i]->setOptions($reservations[$i][7],$reservations[$i][8],$reservations[$i][9]);
    $reservation[$i]->setPrix($reservations[$i][10]);
?>

    <tr>
    <td><?php echo $id_reservation[$i] ?> </td>
    <td><?php echo $login_reservation[$i]; ?> </td>
    <td><?php echo $reservation[$i]->getDateDepart("str"); ?> </td>
    <td><?php echo $reservation[$i]->getDateArrivee("str"); ?> </td>
    <td><?php echo $reservation[$i]->getEquipement("str"); ?> </td>
    <td><?php echo $reservation[$i]->getEmplacement("str"); ?> </td>
    <td><?php echo $reservation[$i]->getBorne("str").$reservation[$i]->getClub("str").$reservation[$i]->getActivites("str") ?> </td>
    <td><?php echo $reservation[$i]->getPrix("str")."€"; ?> </td>
    <td>
    <form method="post" action="admin.php" id="suppression">
    <button type="submit" id="submit" name="resat" value ="<?php echo $id_reservation[$i];?>">Supprimer</button></form>
    </td>
    </tr>

<?php
    //Suppression de la réservation
    if(isset($_POST['resat']))
    {
        $reservation[$i]->delete_resa();
        header('Location:admin.php');
        //$_SESSION['bdd']->execute("DELETE reservations.debut,reservations.fin FROM reservations WHERE `reservations`.`id` = 28");
        //$suppr = $_SESSION['bdd']->execute("DELETE FROM reservations WHERE id = '".$_POST['resat']."'");
        //var_dump($suppr);
    }

}
?>
</tbody>
</table>

<h2>Tableau des prix</h2>
<?php

//Affichage de la liste des prix
$_SESSION['bdd']->connect();
$price=$_SESSION['bdd']->execute("SELECT prix,nom,id FROM prix");
?>
<table>
<thead>
    <tr>
        <th>Type</th>
        <th>Prix</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
<?php
foreach($price as $price3)
{ 
?>

    <tr>
    <td><?php echo $price3[1] ; ?> </td>
    <td><?php echo $price3[0].'€'; ?> </td>
    <td>
    <form method="post" action="admin.php" id="modifier">
    <input type="text" placeholder="Nouveau prix" name="<?php echo $price3[2] ;?>" value ="">
    <input type="submit" id="submit" name="price<?php echo $price3[2];?>" value="Modifier"/>
    </form>
    </td>
    </tr>

    <?php
        //Modifier les prix 
        if(isset($_POST['price'.$price3[2]]))
        {
            $_SESSION['bdd']->update_prix($price3[2]);
            header('Location:admin.php');            
        }
}
        
    ?>

    </tbody>
    </table>
</section>

</main>

<?php require 'footer.php'?>


</body>

</html>