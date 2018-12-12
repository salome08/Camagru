<?php
	session_start();
	ini_set('display_errors', 1);
	if (!isset($_SESSION['login']))
	{
		header('Location: index.php');
		exit();
	}
	require_once('config/database.php');
	if (isset($_POST['envoyer']) && $_POST['envoyer'] == 'Envoyer')
	{
		if (isset($_POST['newLog']) && !empty($_POST['newLog'])	)
		{
			if(!(strlen($_POST['newLog']) > 40))
			{
						$newLog = $_POST['newLog'];
						$login = $_SESSION['login'];	
						$db = dbConnect();
					   $req = $db->prepare("UPDATE user SET login = ? WHERE login = ? ");
		               $req->execute(array($newLog, $login));
		               $_SESSION['login'] = $newLog;
		               $erreur = 'Votre login a été changé';
		    }
			else $erreur = 'champs trop long';			}
		else 
			$erreur = 'Saisissez votre nouveau login';
	}
?>

<html>
<head>
	<meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
<div class="header">
	<a href="preference.php">Retour</a>
</div>
	<title>Camagru</title>
	</head>

<body>
Bonjour <?php echo htmlentities(trim($_SESSION['login'])); ?> !<br />

<fieldset>
<!-- <div class="content"> -->
	<legend> Changement du login :</legend>
	<form action="#" method="post">
	
	<label for="login">Votre nouveau login :</label>
		<input type="text" name="newLog" value="<?php if (isset($_POST['newLog'])) echo htmlentities(trim($_POST['newLog'])); ?>"><br />

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