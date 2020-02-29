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
if($_SESSION['user']->isConnected() != true){
    header('Location:index.php');
}?>
<html>

<head>
        <title>Formulaire de réservation</title> 
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Leckerli+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>

<?php require 'header.php'?>


<main>
<section>
    <h1> Formulaire de réservation </h1>
</section>

</main>

<?php require 'footer.php'?>


</body>

</html>