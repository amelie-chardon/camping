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
    </ul>
 </nav>
    <form  action="index.php" method="post">
	    <input name="deconnexion" value="Se déconnecter" type="submit" />
    </form>
				
		<?php
		if (isset($_POST["deconnexion"]))
            {
         session_unset();
         session_destroy();
         header ('location:index.php');
            }
		?>

 
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