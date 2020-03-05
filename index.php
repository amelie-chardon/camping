<!doctype html>
<html>
<head>
	<meta charset="utf-8">
		<meta name="description" content="Voici la description de l'équipe des codeurs du dimanche">
    <link rel="stylesheet" href="style.css">
		<title>Accueil</title>
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Leckerli+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<?php
require 'class/bdd.php';
require 'class/user.php';

session_start();

?>




<body class="body1">

        <?php require 'header.php';?>

<main>
<section class="centre">
	<h1 id="camping-titre">CAMPING<br/>
	DES HAPPY SARDINES</h1>
	<article class="le-bouton"><a class= "bouton-reserver" href="reservation-form.php">Réservez-vite !</a></article>
</section>
</main>


<?php require 'footer.php'?>


</body>

</html>