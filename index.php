<html>

<?php
require 'class/bdd.php';
require 'class/user.php';
session_start();

if(!isset($_SESSION['bdd']))
{
    $_SESSION['bdd'] = new bdd();
}
if(!isset($_SESSION['user'])){
    $_SESSION['user'] = new user();
}


?>

<head>
	<meta charset="utf-8">
		<meta name="description" content="Voici la description de l'équipe des codeurs du dimanche">
    <link rel="stylesheet" href="style.css">
		<title>Accueil</title>
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Leckerli+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body class="body1">

        <?php require 'header.php';?>

<main>
<section class="centre">
	<h1 id="camping-titre">CAMPING<br/>
	DES HAPPY SARDINES</h1>
	<article class="le-bouton"><a class= "bouton-reserver"
	<?php if($_SESSION['user']->isConnected() != false){echo "href='reservation-form.php'";}
	else{echo "href='inscription.php'}";}?> >Réservez-vite !</a></article>
</section>
</main>


<?php require 'footer.php'?>


</body>

</html>