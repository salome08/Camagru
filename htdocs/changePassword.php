<?php
	session_start();
	if (!isset($_SESSION['login']))
	{
		header('Location: index.php');
		exit();
	}
	require_once('config/database.php');
	if (isset($_POST['envoyer']) && $_POST['envoyer'] == 'Envoyer')
	{
		if ((isset($_POST['oldPass']) && !empty($_POST['oldPass']))	&& (isset($_POST['newPass']) && !empty($_POST['newPass'])))
		{
			if(!(strlen($_POST['newPass']) > 40))
			{
				$login = $_SESSION['login'];
						$oldPass = hash('whirlpool', $_POST['oldPass']);
						$newPass = hash('whirlpool', $_POST['newPass']);
						
							$db = dbConnect();
							$req = $db->prepare("SELECT password FROM user WHERE login like :login ");
							if($req->execute(array(':login' => $login)) && $row = $req->fetch())
							  {
							    $passbdd = $row['password'];	
							  }
							 if ($passbdd == $oldPass)
							 {
			
							   $req = $db->prepare("UPDATE user SET password = :newPass WHERE login like :login");
				               $req->bindParam(':newPass', $newPass);
				               $req->bindParam(':login', $login);
				               $req->execute();
				               $erreur = 'Votre mot de passe a été changée';
				          	}
	           				else $erreur = 'Ancien mot de passe incorrect';

	        }
		      else $erreur = 'champs trop long';	


		}
		else 
			$erreur = 'Saisissez votre nouvelle adresse mail';
	}
?>

<html>
<head>
	<meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
<div class="header">
<a href="preference.php">Retour</a></div>
	<title>Camagru</title>
	</head>

<body>
Bonjour <?php echo htmlentities(trim($_SESSION['login'])); ?> !<br />

<fieldset>
<!-- <div class="content"> -->
	<legend> Changement de votre mot de passe :</legend>
	<form action="#" method="post">
	
	<label for="mail">Ancien mot de passe :</label>
	<input type="text" name="oldPass" value="<?php if (isset($_POST['oldPass'])) echo htmlentities(trim($_POST['oldPass'])); ?>"><br />

	<label for="mail">Nouveau mot de passe :</label>
		<input type="text" name="newPass" value="<?php if (isset($_POST['newPass'])) echo htmlentities(trim($_POST['newPass'])); ?>"><br />

	</br><input type="submit" name="envoyer" value="Envoyer"></br>
	</form>
	<?php
	if (isset($erreur)) echo '<br /><br />',$erreur;
	?>
</fieldset>

<div class="links">
	<a href="deconnexion.php">Deconnexion</a></br>
	<a href="membre.php">Retour acceuil</a>
</div>



<div class="footer"></div>
</body>
</html>