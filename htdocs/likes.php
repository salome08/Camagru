<?php
	session_start();
	if (!isset($_SESSION['login']))
{
	header('Location: gallery.php');
	exit();
}
	require_once('config/database.php');
	$db = dbConnect();
	if (isset($_GET['id']) AND !empty($_GET['id']))
	{
		$post_id = htmlspecialchars($_GET['id']);
		$user_log = htmlspecialchars($_SESSION['login']);
		$check = $db->prepare('SELECT user FROM likes WHERE user = ? AND postid = ?');
		$check->execute(array($user_log, $post_id));
		//si l'useur a deja liker cette photo
		if ($check->rowCount() != 1)
		{ 
			$ins = $db->prepare('INSERT INTO likes(user, postid) VALUES(?, ?)');
			$ins->execute(array($user_log, $post_id));
			// header('Location : http://localhost:8888/htdocs/gallery.php');
		}
	}
?>
<script language="javascript">document.location="gallery.php"</script> 
