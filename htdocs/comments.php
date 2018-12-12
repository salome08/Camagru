<?php
session_start();
if (!isset($_SESSION['login']))
{
	header('Location: gallery.php');
	exit();
}
require_once('config/database.php');
require_once('mail.php');

$db = dbConnect();

if(isset($_GET['id'], $_GET['usr']) AND !empty($_GET['id']))
{
	$post_id = htmlspecialchars($_GET['id']);
	$user_log = htmlspecialchars($_SESSION['login']);
	$img_user = htmlspecialchars($_GET['usr']);

	

	//envoyer un commentaire 
	if (isset($_POST['envoyer'])){
		if(isset($_POST['comment']) AND !empty($_POST['comment'])){
			$comment = htmlspecialchars($_POST['comment']);

			$ins = $db->prepare('INSERT INTO comments (user, postid, comment) VALUES (?, ?, ?)');
			$ins->execute(array($user_log, $post_id, $comment));

		//envoi mail de confirmation 
			//check si reception de mail est active
			$check_mail = $db->prepare('SELECT * FROM user WHERE login = ? AND mailcom IS NULL');
			$check_mail->execute(array($img_user));

			if ($check_mail->rowCount() == 1)
			{
				$res = $check_mail->fetch();
				send_commentaire_mail($res['mail'], $img_user, $user_log);
			}	
		}
		else 
			$error = "Tous les champs doivent etre complétés !";
	}
}
	//afficher les commentaires 
	$commentaires = $db->prepare('SELECT * FROM comments WHERE postid = ? ORDER BY id DESC');
	$commentaires->execute(array($post_id));
?>



<html>
<head>

	<meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
<div class="header">
<a href="gallery.php">Gallery</a>
</div>
	<title>Commentaires</title>
	</head>

<body>
<fieldset>
<!-- <div class="content"> -->
	<legend> Laisser un commentaire :</legend>
	<form method="post">
	
	<label for="login">Votre commentaire :</label>
		<textarea placeholder="Ecrivez..." name="comment" rows="5" cols="40"></textarea><br />
	
	</br><input type="submit" name="envoyer" value="Envoyer"></br>
	</form>
</fieldset>
<?php 
	if (isset($error)){echo ($error);}
?>
</br>
<?php
	while ($c = $commentaires->fetch()){ ?>
	<b><?= $c['user']	?> : </b> <?= $c['comment']?> </br>


	<?php } ?>

<div class="footer"></div>
</body>
</html>