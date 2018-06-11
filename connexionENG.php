<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=id6089149_espace_membre', 'id6089149_gauthier', 'liogau99');

if(isset($_POST['formconnexion'])) {
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];
         header("Location: profil.php?id=".$_SESSION['id']);
      } else {
         $erreur = "Wrong mail ou password !";
      }
   } else {
      $erreur = "All fields must be completed !";
   }
}
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
         <h2>Log in</h2>
         <br /><br />
         <form method="POST" action="">
            <input type="email" name="mailconnect" placeholder="Mail" />
            <input type="password" name="mdpconnect" placeholder="Password" />
            <br /><br />
            <input type="submit" name="formconnexion" value="Log in !" />
         </form>
         <?php
         if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
      </div>
   </body>
</html>