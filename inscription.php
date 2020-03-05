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
        <title>Inscription</title> 
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Leckerli+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body class="body1">

<?php require 'header.php'?>

    <main>

    <section class="inscription">
                 <h1 class="text-inscription">INSCRIPTION</h1>
    
        <form class="formulaire" action="inscription.php" method="post">

            <input type="text" name="login" class="largeur" placeholder="Login" required><br>
            <input type="mail" name="mail" class="largeur" placeholder="Adresse Mail" required><br>
            <input type="password" name="password" class="largeur" minlength="5" placeholder="Mot de passe" required><br>
            <input type="password" name="passwordconf" class="largeur" minlength="5" placeholder="Confirmer le mot de passe" required/><br>
           <input type="submit" name="send" value="S'inscrire">
        </form>

    </section>
<section>
<?php

if(isset($_POST['send'])){
    if($_SESSION["user"]->inscription($_POST['login'],$_POST["password"],$_POST['passwordconf'],$_POST['mail']) == "ok"){
        ?>
        <p>Le compte a été créé.</p>
        <?php
    }
    elseif($_SESSION["user"]->inscription($_POST['login'],$_POST["password"],$_POST['passwordconf'],$_POST['mail']) == "log"){
        ?>
            <p>L'identifiant ou l'email est déjà pris.</p>
        <?php
    }
    elseif($_SESSION["user"]->inscription($_POST['login'],$_POST["password"],$_POST['passwordconf'],$_POST['mail']) == "empty"){
        ?>
            <p>Veuillez remplir tous les champs.</p>
        <?php
    }
    elseif($_SESSION["user"]->inscription($_POST['login'],$_POST["password"],$_POST['passwordconf'],$_POST['mail']) == "mdp"){
        ?>
            <p>Les mots de passes ne sont pas identiques.</p>
        <?php
    }
}
?>
</section>

    </main>

<?php require 'footer.php';?>


</body>

</html>