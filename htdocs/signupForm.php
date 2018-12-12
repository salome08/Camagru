<?php
	
	require_once('config/database.php');
	$mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;
	$mail = strtolower($mail);
	$login = isset($_POST['login']) ? $_POST['login'] : NULL;
	$pass = isset($_POST['pass']) ? $_POST['pass'] : NULL;
	if (isset($_POST['inscription']) && $_POST['inscription'] == 'Inscription')
	{
		if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass'])) && (isset($_POST['mail']) && !empty($_POST['mail'])))
		{
			if(!(strlen($_POST['login']) > 40) OR !(strlen($_POST['mail']) > 40) OR !(strlen($_POST['pass']) > 40))
			{
				$db = dbConnect();
							if (!(filter_var($mail, FILTER_VALIDATE_EMAIL)))
								$erreur = 'adresse email wrong format';
							else
							{
								$req = $db->prepare('SELECT * FROM user WHERE mail=?');
								$req->execute(array($mail));
								$done = $req->fetchAll();
								$nb_result = count($done);
								if ($nb_result == 1)
									$erreur = 'Vous etes deja inscrit';
								else
								{
									$req = $db->prepare('SELECT * FROM user WHERE login=?');
									$req->execute(array($login));
									$done = $req->fetchAll();
									$nb_result = count($done);
									if ($nb_result == 1)
										$erreur = 'ce login est deja utilise';
									else
									{
										$req = $db->prepare('INSERT INTO user(mail, login, password) VALUES(?, ?, ?)');
										$req->execute(array($mail, $login, hash('whirlpool', $pass)));
				
										//generation d'une cle aleatoire
										$cle = uniqid(rand(), true);
				
										//inclu dans la table 
										$req = $db->prepare('UPDATE user SET cle=:cle WHERE login LIKE :login');
										$req->bindParam(':cle', $cle);
										$req->bindParam(':login', $login);
										$req->execute();
										require('mail.php');
										send_confirmation_mail($mail, $login, $cle);
										// session_start();
										// header('Location: logForm.php');
										// exit();
									}
								}
							}		
						}
				else $erreur = 'champs trop long';	

		}
		else $erreur = 'au moins un champs est vide';
	}
?>
<html>
<head>
        <link rel="stylesheet" href="style.css" />

<title>Inscription</title>
</head>
<div class="header"></div>

<body>
	<fieldset>
		<legend>Inscription à l'espace membre :</legend>
<form action="signupForm.php" method="post">
Votre login : <input type="text" name="login" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>"><br />
Mot de passe : <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"   required title="6 caractères, un chiffre et 1 maj" type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>"><br />
Adresse email : <input type="text" name="mail" value="<?php if (isset($_POST['mail'])) echo htmlentities(trim($_POST['mail'])); ?>"><br />
<input type="submit" name="inscription" value="Inscription">
</form>
</fieldset>
<div class="links">
  <a href="logForm.php">Vous connectez</a></br>
</div>
<?php
if (isset($erreur)) echo '<br />',$erreur;
?>
</body>
<div class="footer"></div>

</html>