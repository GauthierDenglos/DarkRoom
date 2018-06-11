<?php
$bdd = new PDO('mysql:host=localhost;dbname=id6089149_espace_membre', 'id6089149_gauthier', 'liogau99'); //mettre le nom de la base de donnée timer 11:25
if (isset($_POST['forminscription'])) 
{
	$pseudo = htmlspecialchars($_POST['pseudo']);
	$mail = htmlspecialchars($_POST['mail']);
	$mail2 = htmlspecialchars($_POST['mail2']);
	$mdp = sha1($_POST['mdp']);
	$mdp2 = sha1($_POST['mdp2']);

	if (!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) 
	{

		$pseudolength = strlen($pseudo); 
		if ($pseudolength <= 255) 
		{
			if ($mail2 == $mail) 
			{
				if (filter_var($mail, FILTER_VALIDATE_EMAIL)) 
				{
					$reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ? ");
					$reqmail->execute(array($mail));
					$mailexist = $reqmail->rowCount(); 
					if ($mailexist == 0) 
					{
						if ($mdp == $mdp2) 
						{
							$insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?, ?, ?)"); // Voir dans la base de donnée (nom des tables) timer 26:50
							$insertmbr->execute(array($pseudo, $mail, $mdp));
							$erreur = "Your account has been created!<a href=\"connexion.php\">Log in</a>"; 
							// $_SESSION['comptecree'] = "Votre compte a bien été créé !"; 
							// header('Location: index.php'); //Redirige l'utilisateur vers une autre page timer 30:00
						}
						else
						{
							$erreur = "The two passwords don't match ! ";
						}
					}
					else
					{
						$erreur = "This mail is already used ! ";
					}
				}
				else
				{
					$erreur = "This mail is not correct !";
				}
			}
			else
			{
				$erreur = "The two mails don't match !";
			}
		}
		else
		{
			$erreur = "Your name must be less than 255 !";
		}
	}
	else
	{
		$erreur = "all fields must be completed ! ";
	}
}
?>

<!DOCTYPE html> <!--Espace html pour le formulaire, a rendre esthétique quand on aura la base de donnée -->
<html>
	<head>
		<title>DarkRoom</title>
		<meta charset="utf-8" />
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
			<h2> Inscription </h2>
			<br/> <br/> <br/>
			<form method="POST" action=""> 

			<label for="pseudo"> Name: </label>
			<input type="text" placeholder="Your name" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" > <br /><br />

			<label for="mail"> Mail: </label>
			<input type="email" placeholder="Your mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" > <br /><br />

			<label for="mail2"> Confirm your mail: </label>
			<input type="email" placeholder="Confirm your mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" > <br /><br />

			<label for="mdp"> Password: </label>
			<input type="password" placeholder="Password" id="mdp" name="mdp"> <br /><br />

			<label for="mdp2"> Confirm your password: </label>
			<input type="password" placeholder="Confirm your pw" id="mdp2" name="mdp2"> <br /><br />
			<input type="submit" name="forminscription" value="I sign in!"> <br /><br />

			</form>
			<?php
			if (isset($erreur)) 
			{
				echo '<font color="red">'.$erreur."</font>";
			}
			?>
		</div>
	</body>
</html>