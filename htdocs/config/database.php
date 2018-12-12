<?php
function dbConnect()
{
	$db = new PDO('mysql:host=localhost', 'root', 'salome');
	$db->exec('CREATE DATABASE IF NOT EXISTS `camagru` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;');
	$db_host = "localhost";
	$db_name = "camagru";
	$db_user = "root";
	$db_pass = "salome";
	try{
		$db_con = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8",$db_user,$db_pass);
		$db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return($db_con);
	}
	catch(PDOException $e){
		{
			echo $e->getMessage();
			exit();
		}
	}
}
?>