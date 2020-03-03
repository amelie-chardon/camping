<header>

<?php
date_default_timezone_set('UTC');


if (isset($_SESSION['login']))
 {
    $login = $_SESSION['login'];
    $today = date("d.m.y")
?>

<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="profil.php">Mon compte</a></li>
        <li><a href="reservation-form.php">Réserver</a></li>
        
        <?php 
        if(isset($_SESSION['role'])){
        ?>
        <li><a href="admin.php">Admin</a>
            <?php
        }
        ?>
        <li><a href="deconnexion.php">Déconnexion</a></li>
    </ul>
 </nav>
<?php 
}
else
 {
?>
<nav>
    <ul>
            <li><a href="index.php"> Accueil</a></li>
            <li><a href="inscription.php"> Inscription</a></li>
            <li><a href="connexion.php"> Connexion</a></li> 
             
     </ul>
</nav>

<?php
 }
?>

</header>