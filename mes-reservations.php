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
        <title>Mes réservations</title> 
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Leckerli+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body class="body1">

<?php require 'header.php'?>
<section class="centre2">
	<h1 class="modifier">Mes réservations</h1>
<section class="le-tableau">
	<table>
		<thead>
			<th>Date de début</th>
			<th>Date de fin</th>
			<th>Equipement</th>
			<th>Emplacement</th>
			<th>Options</th>
			<th>Prix</th>
		</thead>
<tbody>
<?php
	     $_SESSION['bdd']->connect();
        $reservations=$_SESSION['bdd']->execute("SELECT * FROM reservations INNER JOIN utilisateurs ON utilisateurs.id=reservations.id_utilisateur WHERE utilisateurs.login='".$_SESSION["user"]->getlogin()."'");
		for($i=0;$i<count($reservations);$i++)
		{
			$id_reservation[$i]=$reservations[$i][0];
			$login_reservation[$i]=$reservations[$i][12];
			$reservation[$i]=new reservation();
			$reservation[$i]->setDate($reservations[$i][1],$reservations[$i][2]);
			$reservation[$i]->setNbJours();
			$reservation[$i]->setEmplacement($reservations[$i][5]);
			$reservation[$i]->setEquipement($reservations[$i][6]);
			$reservation[$i]->setNbEmplacements();
			$reservation[$i]->setOptions($reservations[$i][7],$reservations[$i][8],$reservations[$i][9]);
			$reservation[$i]->setPrix();
		?>
		
			<tr>
				<td><?php echo $reservation[$i]->getDateArrivee("str"); ?> </td>
				<td><?php echo $reservation[$i]->getDateDepart("str"); ?> </td>
				<td><?php echo $reservation[$i]->getEquipement("str"); ?> </td>
				<td><?php echo $reservation[$i]->getEmplacement("str"); ?> </td>
				<td><?php echo '<p>'.$reservation[$i]->getBorne("str").'</p><p>'.$reservation[$i]->getClub("str").'</p><p>'.$reservation[$i]->getActivites("str").'</p>' ?> </td>
				<td><?php echo $reservation[$i]->getPrix("str")."€"; ?> </td>
			</tr>
	
<?php
		}	
?>
		</tbody>
	</table>
</section>
</section>
<?php require 'footer.php'?>


</body>

</html>