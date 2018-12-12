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
		if (isset($_POST['newMail']) && !empty($_POST['newMail'])	)
		{
			if(!(strlen($_POST['newMail']) > 40))
			{
				$newMail = $_POST['newMail'];
				$login = $_SESSION['login'];
				$db = dbConnect();
			   $req = $db->prepare("UPDATE user SET mail = ? WHERE login like ? ");
	           $req->execute(array($newMail, $login));
	           $erreur = 'Votre adresse mail a été changée';
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
	<legend> Changement de l'adresse mail :</legend>
	<form action="#" method="post">
	
	<label for="mail">Votre nouveau mail :</label>
		<input type="text" name="newMail" value="<?php if (isset($_POST['newMail'])) echo htmlentities(trim($_POST['newMail'])); ?>"><br />

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