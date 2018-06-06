<?php
$bdd = new PDO(''); //mettre le nom de la base de donnée timer 11:25
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
							$erreur = "Votre compte a bien été créé !<a href=\"connexion.php\">Me connecter</a>"; 
							// $_SESSION['comptecree'] = "Votre compte a bien été créé !"; 
							// header('Location: index.php'); //Redirige l'utilisateur vers une autre page timer 30:00
						}
						else
						{
							$erreur = "Vos deux mots de passe ne correspondent pas ! ";
						}
					}
					else
					{
						$erreur = "Adresse mail déjà utilisée ! ";
					}
				}
				else
				{
					$erreur = "Votre adresse mail n'est pas valide !";
				}
			}
			else
			{
				$erreur = "Vos deux adresses mail ne correspondent pas !";
			}
		}
		else
		{
			$erreur = "Votre pseudo doit faire moins de 255 charactères.";
		}
	}
	else
	{
		$erreur = "tous les champs doivent être completés ! ";
	}
}
?>
<!DOCTYPE html> <!--Espace html pour le formulaire, a rendre esthétique quand on aura la base de donnée -->
<html>
	<head>
		<title>DarkRoom</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<div align="center">  
			<h2> Inscription </h2>
			<br/> <br/> <br/>
			<form method="POST" action=""> 
				<table>
					<tr>
						<td align="right">
							<label for="pseudo"> Pseudo: </label>
						</td>
						<td align="right">
							<input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" >
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mail"> Mail: </label>
						</td>
						<td align="right">
							<input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" >
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mail2"> Confirmez votre mail: </label>
						</td>
						<td align="right">
							<input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" >
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mdp"> Mot de passe: </label>
						</td>
						<td align="right">
							<input type="password" placeholder="Mot de passe" id="mdp" name="mdp">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mdp2"> Confirmez votre mot de passe: </label>
						</td>
						<td align="right">
							<input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2">
						</td>
					</tr>
					<br/>
					<tr>
						<td></td>
						<td> <input type="submit" name="forminscription" value="Je m'inscris"> </td>
					</tr>
				</table>
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