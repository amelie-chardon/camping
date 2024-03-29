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
        <title>Mon compte</title> 
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Leckerli+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body class="body2">

<?php require 'header.php'?>
	<h1 id="titre">Bienvenue <?php echo $_SESSION["user"]->getlogin(); ?>
	<h2 class="modifier">Mes réservations</h1>
<section class="mes-reservations">
		<article class="le-bouton2"><a class= "bouton-reserver" href="mes-reservations.php">Voir mes réservations</a></article>
</section>


<main>
<section class="formulaire">
	<form method="post" action="profil.php">
		<h2 class="modifier">Modifier mon identifiant</h1>
		<label>
			<input type="text" name="login" class="largeur" id="login" placeholder="Nouvel identifiant*" required/><br/>
		</label>
		<label>
			<input type="password" name="motdepasse" class="largeur" id="motdepasse" placeholder="Mot de passe*" required/><br/>
		</label>
		<label>
	  		<input type="submit" name="submit" id="bouton" value="Valider" />
	 	</label>
	</form>
	
<?php
	if(isset($_POST['submit'])) 
	{
		$login = $_POST['login'];
		$password = $_POST['motdepasse'];
		
		if(!empty($login) && !empty($password))
		{
			$connect = mysqli_connect('localhost','root','', 'camping') or die ('Error');
			$query = "SELECT * FROM utilisateurs WHERE login = '".$_SESSION["user"]->getlogin()."'";
			$reg = mysqli_query ($connect,$query);
			/*permet de lire/retourner une ligne du tableau, la première par défaut*/
			$rows = mysqli_fetch_assoc($reg);
			
			if(password_verify($_POST['motdepasse'], $rows['mdp']))
			{
				$query2 = "UPDATE utilisateurs SET login = '".$login."' WHERE login = '".$_SESSION["user"]->getlogin()."'";
				$reg = mysqli_query($connect, $query2);
				$_SESSION["user"]->connexion($login,$password);
				echo "<p class='inscription-error'>Votre identifiant a bien été modifié.</p>";
			} 
			else {echo "<p class='inscription-error'>Mot de passe incorrect</p>";}
			
		}else {echo "<p class='inscription-error'>Veuillez saisir tous les champs</p>";}
	} 
?>
</section>

<section class="formulaire" >
	<form method="post" action="profil.php">
		<h2 class="modifier">Modifier mon mot de passe</h1>
		<label>
			<input type="password" name="ancienmotdepasse" class="largeur" id="login" minlength="5" placeholder="Ancien mot de passe*" required/><br/>
		</label>
		<label>
			<input type="password" name="nouveaumotdepasse" class="largeur" id="motdepasse" minlength="5" placeholder="Nouveau mot de passe*" required/><br/>
		</label>
		<label>
	  		<input type="submit" name="submit2" id="bouton" value="Valider" />
	 	</label>
	</form>

<?php
	if(isset($_POST['submit2'])) 
	{
		$ancienpassword = $_POST['ancienmotdepasse'];
		$newpassword = $_POST['nouveaumotdepasse'];
		
		if(!empty($newpassword) && !empty($ancienpassword))
		{

			$connect = mysqli_connect('localhost','root','', 'camping');
			$query = "SELECT * FROM utilisateurs WHERE login = '".$_SESSION["user"]->getlogin()."'";
			$reg = mysqli_query ($connect,$query);
			/*permet de lire/retourner une ligne du tableau, la première par défaut*/
			$rows = mysqli_fetch_assoc($reg);
			
			if(password_verify($_POST['ancienmotdepasse'], $rows['mdp']))
			{
				//var_dump($ancienpassword);//
				$query2 = "UPDATE utilisateurs SET mdp = '".password_hash($newpassword, PASSWORD_DEFAULT)."' WHERE login = '".$_SESSION["user"]->getlogin()."'";
				$reg = mysqli_query($connect, $query2);
				echo "<p class='inscription-error'>Votre mot de passe a bien été modifié.</p>";
			} 
			else {echo "<p class='inscription-error'>Mot de passe incorrect</p>";}
		}else {echo "<p class='inscription-error'>Veuillez saisir tous les champs</p>";}
	} 
?>
</section>

<section class="formulaire">
	<form method="post">
		<h2 class="modifier">Me déconnecter</h1>
		<label>
	  		<input type="submit" name="submit3" id="bouton" value="Se déconnecter" />
	 	</label>
	</form>
<?php
	if (isset($_POST['submit3']))
	{
		header("location:deconnexion.php");
	}
?>
</section>

<section class="formulaire">
	<form method="post">
		<h2 class="modifier">Me désinscrire</h1>
		<label>
			<input type="password" name="desinscription" class="largeur" id="login" placeholder="Confirmation du mot de passe*" required/><br/>
		</label>
		<label class="se-desinscrire">
	  		<input type="submit" name="submit4" id="bouton2" value="Se désinscrire" />
	 	</label>
	</form>
<?php
	if (isset($_POST['submit4']))
	{
		if (isset($_POST['desinscription']))
		{
			$connect = mysqli_connect('localhost','root','','camping') or die ('Error');
			$query = "SELECT*FROM utilisateurs WHERE login= '".$_SESSION["user"]->getlogin()."'";
			$reg = mysqli_query($connect,$query);
			$rows= mysqli_fetch_assoc($reg);
			
			if (password_verify($_POST['desinscription'], $rows['mdp']))
			{
			$query = "DELETE FROM utilisateurs WHERE login = '".$_SESSION["user"]->getlogin()."'";
            $reg = mysqli_query ($connect,$query);
			session_destroy();
			header('location: index.php');
			
			} else echo "<p class='inscription-error2'>Mot de passe incorrect</p>";
			
		} else echo "<p class='inscription-error2'>Veuillez saisir le mot de passe</p>";
	}
?>
</section>	
</main>
<?php require 'footer.php'?>


</body>

</html>