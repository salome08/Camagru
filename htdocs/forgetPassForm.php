<?php
	require_once('config/database.php');
	if (isset($_POST['envoyer']) && $_POST['envoyer'] == 'Envoyer')
	{
		if (isset($_POST['mail']) && !empty($_POST['mail'])	)
		{
			$mail = strtolower($_POST['mail']);
			require('mail.php');
			//sql cherge si mail existe, si oui recuperer login 
			$db = dbConnect();
			$req = $db->prepare("SELECT login,cle FROM user WHERE mail LIKE :mail");
			if($req->execute(array(':mail' => $mail)) && $row = $req->fetch())
			{
				$login = $row['login'];
				$cle = $row['cle'];
				send_forget_password($mail, $login, $cle);
				$erreur = 'Vous allez recevoir un mail de reinitialisation';

			}
			else 
				$erreur = 'vous n\'etes pas encore inscrit';
		}
		else 
			$erreur = 'Saisissez votre adresse mail';
	}
?>

<html>
<head>
	<meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
<div class="header"></div>
	<title>Camagru</title>
	</head>

<body>
<fieldset>
<!-- <div class="content"> -->
	<legend> Mot de passe oublié :</legend>
	<form action="forgetPassForm.php" method="post">
	
	<label for="mail">Votre adresse mail :</label>
		<input type="text" name="mail" value="<?php if (isset($_POST['mail'])) echo htmlentities(trim($_POST['mail'])); ?>"><br />

	</br><input type="submit" name="envoyer" value="Envoyer"></br>
	</form>
	<?php
	if (isset($erreur)) echo '<br /><br />',$erreur;
	?>
</fieldset>

	<a href="signupForm.php">Vous inscrire</a></br>
	<a href="forgetPassForm.php">Mot de passe oublié</a>



<div class="footer"></div>
</body>
</html>