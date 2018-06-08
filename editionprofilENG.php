<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=id6089149_espace_membre', 'id6089149_gauthier', 'liogau99');

if(isset($_GET['id']) AND $_GET['id'] > 0) 
{
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
?>

<html>
   <head>
      <title>Darkroom</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="Projet.css" /> 
   </head>
   <body>
      <body  class="Introduction">

      <div id="wrapperHeader">
       <div id="header">
                <img src="Images/logo.jpg" width="250" height="250" alt="logo" />
       </div> 
      </div>
      <div id="navbar">>
            <a href="Download.html">Download</a>
            <a href="Galerie.html">Pictures</a>
            <a href="LiensUtiles.html">Usefull Links</a>
            <a href="index.html">Homepage</a>
            <a class="active" href="Presentation.html">Presentation</a>
      </div>
      <div align="center">
         <h2>Profile of <?php echo $userinfo['pseudo']; ?></h2>
         <br /><br />
         <p class="Text"> Name = </p> <?php echo $userinfo['pseudo']; ?>
         <br />
         <p class="Text"> Mail = </p><?php echo $userinfo['mail']; ?>
         <br />
         <?php
         if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
         ?>
         <br />
         <a href="editionprofil.php">Edit your profile</a>
         <a href="deconnexion.php">Log out</a>
         <?php
         }
         ?>
      </div>
   </body>
</html>
<?php   
}
?>