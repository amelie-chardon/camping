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

<body class="body1">

<?php require 'header.php'?>
<section class="centre2">
	<h1 class="modifier">Mes réservations</h1>
<section class="le-tableau">
	<table>
		<thead>
			<th>Date de début</th>
			<th>Date de fin</th>
			<th>Emplacement</th>
			<th>Nombre d'emplacements</th>
			<th>Borne</th>
			<th>Club</th>
			<th>Activité</th>
			<th>Prix</th>
		</thead>
<tbody>
<?php
	     $_SESSION['bdd']->connect();
        $reservations=$_SESSION['bdd']->execute("SELECT * FROM reservations INNER JOIN utilisateurs ON utilisateurs.id=reservations.id_utilisateur WHERE utilisateurs.login='".$_SESSION["user"]->getlogin()."'");
	    foreach($reservations as $reservation)
		{
			    //$reservation = new reservation();
?>
	
		<tr>
			<td><?php echo $reservation[1];?></td>
			<td><?php echo $reservation[2];?></td>
			<td><?php echo $reservation[5];?></td>
			<td><?php echo $reservation[6];?></td>
			<td><?php echo $reservation[7];?></td>
			<td><?php echo $reservation[8];?></td>
			<td><?php echo $reservation[9];?></td>
			<td><?php echo $reservation[10];?></td>
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