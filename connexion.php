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
if($_SESSION['user']->isConnected() != false){
    header('Location:index.php');
}
?>



<head>
<meta charset="utf-8" />
        <title>Connexion</title> 
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Leckerli+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

</head>

<body class="body1">

<?php require 'header.php'?>


<main>

<section class="inscription">
                 <h1 class="text-inscription"> CONNEXION </h1>
   
        <form class="formulaire" action="connexion.php" method="post">
        	<input type="text" name="login" class="largeur" placeholder="login" required><br>
            <input type="password" name="password" class="largeur" placeholder="Mot de passe" required><br>
            <input type="submit" name="send">
        </form>

</section>
<section>
<?php
if(isset($_POST["send"])){
    if($_SESSION["user"]->connexion($_POST["login"],$_POST["password"]) == false){
        ?>
            <p>Un problème est survenue lors de la connexion. Veuillez vérifer vos informations de connexion.</p>
        <?php
    }
    else{
        $_SESSION["user"]->connexion($_POST["login"],$_POST["password"]);
        $_SESSION["login"] = false;
        if($_SESSION['user']->getrole() == "admin"){
            $_SESSION["role"] = true;
        }
        header('location:index.php');
    }
    
}

?>
</section>

</main>

<?php require 'footer.php'?>

</body>

</html>