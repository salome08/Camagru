<?php
	session_start();
	if (!isset($_SESSION['login']))
	{
		header('Location: index.php');
		exit();
	}
	require_once('config/database.php');
	$db = dbConnect();
	$login = htmlspecialchars($_SESSION['login']);
	if (isset($_POST['submit']))
	{
		if(isset($_POST['sendmail']) AND !empty($_POST['sendmail']))
		{
			if($_POST['sendmail'] == 'oui')
			{
				$req = $db->prepare("UPDATE user SET mailcom = NULL WHERE login = ?");
				$req->execute(array($login));
			}
			else
			{	 
				$req = $db->prepare("UPDATE user SET mailcom = '1' WHERE login = ?");
				$req->execute(array($login));
			}
			$msg = "Les modifications ont été mises à jour";
		}
	}
?>


<html>
<head>

	<meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
<div class="header">
	<a href="deconnexion.php">Déconnexion</a>
<a href="membre.php">Retour</a>
</div>
	<title>Camagru</title>
	</head>

<body>
	<a href="changeLogin.php">Modifier login</a></br>
<a href="changeMail.php">Modifier mail</a></br>
<a href="changePassword.php">Modifier mot de passe</a></br>
<form method="POST">
	Etre informer par mail a la publication d'un commentaire sur ta photo ?</br>
	Oui : <input type="radio" name="sendmail" value="oui"></br>
	Non : <input type="radio" name="sendmail" value="non"></br>
	<input type="submit" name="submit" value="Modifier">

</form>
<?php if(isset($msg)){echo($msg);} ?>
</body>
<div class="footer"></div>

</html>