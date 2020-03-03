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
if($_SESSION['user']->getrole() != "admin"){
    header('Location:index.php');
}

?>
<html>

<head>
        <title>Administration</title> 
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Leckerli+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>

<?php require 'header.php'?>


<main>
<section>
    <h1> Administration du site </h1>
            
</section>


<?php
$_SESSION['bdd']->connect();
$price=$_SESSION['bdd']->execute("SELECT prix,nom FROM prix");
//var_dump($price);
$resa=$_SESSION['bdd']->execute("SELECT reservations.debut,reservations.fin,reservations.id,utilisateurs.login  FROM reservations INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id");
//var_dump($resa);
$_SESSION['bdd']->close();

foreach($resa as $resat) 
{ 
     
?>
<table>
<thead>
    <tr>
        <th>Date de debut </th>
        <th>Date de fin</th>
        <th>Prix</th>
        <th>Client</th>
    </tr>
</thead>
<tbody>
    <tr>
    <td><?php echo $resat[0] ; ?> </td>
    <td><?php echo $resat[1] ; ?> </td>
    <td><?php echo $resat[2] ; ?> </td>
    <td><?php echo $resat[3] ; ?> </td>
    <td>
    <form method="post" action="admin.php" id="suppression">
    <button type="submit" id="submit" name="resat" value ="<?php echo $resat[2];?>">Supprimer</button></form>
    </td>
    </tr>
</tbody>
</table>
<?php
//*suppression de l'article 
if(isset($_POST['resat']))
{
    $_SESSION['bdd']->delete();
    header('Location:admin.php');
    //$_SESSION['bdd']->execute("DELETE reservations.debut,reservations.fin FROM reservations WHERE `reservations`.`id` = 28");
    //$suppr = $_SESSION['bdd']->execute("DELETE FROM reservations WHERE id = '".$_POST['resat']."'");
    //var_dump($suppr);
}

}
$_SESSION['bdd']->connect();
$price=$_SESSION['bdd']->execute("SELECT prix,nom,id FROM prix");
foreach($price as $price3) 
{ 
     
?>
<table>
<thead>
    <tr>
        <th>Type</th>
        <th>Prix</th>
        <th></th>
    </tr>
</thead>
<tbody>
    <tr>
    <td><?php echo $price3[1] ; ?> </td>
    <td><?php echo $price3[0] ; ?> </td>
    <td></td>
    <td>
    <form method="post" action="admin.php" id="modifier">
    <input type="text" name="<?php echo $price3[2] ;?>" value =""></td>
    <td>
    <input type="submit" id="submit" name="price<?php echo $price3[2];?>" value="Modifier"/>
    </form>
    </td>
    </tr>
</tbody>
  </table>  
<?php
//Modifier les prix 

if(isset($_POST['price'.$price3[2]]))
{
    $_SESSION['bdd']->update($price3[2]);
    header('Location:admin.php');
    
    
}

}
    
?>

</main>

<?php require 'footer.php'?>


</body>

</html>