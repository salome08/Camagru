 <?php
session_start();
if (!isset($_SESSION['login']))
{
	header('Location: index.php');
	exit();
}
require_once('config/database.php');
ini_set('display_errors', 1);
$db = dbConnect();
if(isset($_POST['geturl']))
{
  $url = $_POST['geturl'];
  $user = $_SESSION['login']; 
  $ins = $db->prepare('INSERT INTO pictures(image, user) VALUES(?, ?)');
  $ins->execute(array($url, $user));
  echo ($url);
}
?>