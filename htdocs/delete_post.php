<?php
session_start();
if (!isset($_SESSION['login']))
{
	header('Location: gallery.php');
	exit();
}
require_once('config/database.php');

$db = dbConnect();

if(isset($_GET['id'], $_GET['usr']) AND !empty($_GET['id']))
{
	$post_id = htmlspecialchars($_GET['id']);
	$user_log = htmlspecialchars($_SESSION['login']);
	$img_user = htmlspecialchars($_GET['usr']);
	if ($img_user == $user_log)
	{
		$dell1 = $db->prepare('DELETE FROM pictures WHERE id = ?');
		$dell1->execute(array($post_id));
		$dell2 = $db->prepare('DELETE FROM likes WHERE postid = ?');
		$dell2->execute(array($post_id));
		$dell3 = $db->prepare('DELETE FROM comments WHERE postid = ?');
		$dell3->execute(array($post_id));
		echo "Image supprimée !";
	}
	else 
		echo "Vous ne pouvez pas supprimer cette image !";
}
?>
<script language="javascript">document.location="gallery.php"</script> 
