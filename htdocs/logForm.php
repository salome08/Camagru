<?php
	require_once('config/database.php');
	$login = isset($_POST['login']) ? $_POST['login'] : NULL;
	$pass = isset($_POST['pass']) ? hash('whirlpool', $_POST['pass']) : NULL;
	if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') 
	{
		if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) 
		{
			$db = dbConnect();
			$req = $db->prepare('SELECT * FROM user WHERE login=? AND password=? AND actif=1');
			$req->execute(array($login, $pass));
			$done = $req->fetchAll();
			$nb_result = count($done);
			if ($nb_result == 1)
			{
				session_start();
				$_SESSION['loggedin'] = true;
				$_SESSION['login'] = $login;
				header('Location: membre.php');
				exit();
			}
			else $erreur = 'Compte non reconnu.';
		}
		else $erreur = 'Au moins un des champs est vide.';
	}
?>

<html>
<head>

	<meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
<div class="header">
<a href="gallery.php">Gallery</a>
</div>
	<title>Camagru</title>
	</head>

<body>
<fieldset>
<!-- <div class="content"> -->
	<legend> Connexion à l'espace membre :</legend>
	<form action="logForm.php" method="post">
	
	<label for="login">Votre login :</label>
		<input type="text" name="login" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>"><br />
	
	<label for="mdp">Mot de passe :</label>
		<input type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>"><br />
	</br><input type="submit" name="connexion" value="Connexion"></br>
	</form>
	<?php
	?>
</fieldset>
<div class="links">
	<a href="signupForm.php">Vous inscrire</a></br>
	<a href="forgetPassForm.php">Mot de passe oublié</a>
</div>


<div class="footer"></div>
</body>
</html>