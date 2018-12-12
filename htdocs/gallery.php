<?php
	session_start();
	ini_set('display_errors', 1);
		require_once('config/database.php');
		
	//database connexion
	$db = dbConnect();

	//find how many rows (= how many images) in the table
	$sql = 'SELECT id, image, text FROM pictures';
	$req = $db->prepare($sql);
	$req->execute();
 	$countrows = $req->rowCount();

 	$rowsperpage = 6;
 	$totalpages = ceil($countrows/$rowsperpage);

 	//get the current page
 	if(isset($_GET['currentpage']) && is_numeric($_GET['currentpage']))
 	{
 		$currentpage = (int)$_GET['currentpage'];
 	}
 	else{
 		$currentpage = 1;
 	}

 	if ($currentpage != 0 && $rowsperpage != 0)
 		$offset = ($currentpage - 1) * $rowsperpage;
 	else 
 		$offset = ($currentpage) * $rowsperpage;

 	$sql = 'SELECT id, image, text , user FROM pictures ORDER BY id DESC LIMIT ' . $offset . ',' . $rowsperpage;
	$req = $db->prepare($sql);
	$req->execute();
	$req->bindColumn(1, $id);
	$req->bindColumn(2, $cover, PDO::PARAM_LOB);
	$affimg = 0;

	//$row[image | likes ], affichage posts
	while($row = $req->fetch())
	{
			$id = $row['id'];
			$image = $row['image'];
			$img_user = $row['user'];

			// $sql2 = 'SELECT * FROM likes where userid=1 AND postid='.$row['id'];
			// $req2 = $db->prepare($sql2);
			// $req2->execute();
			$nb_likes = $db->prepare('SELECT * FROM likes WHERE postid = ?');
			$nb_likes->execute(array($id));
			$likes = $nb_likes->rowCount();
			
			$nb_coms = $db->prepare('SELECT * FROM comments WHERE postid = ?');
			$nb_coms->execute(array($id));
			$coms = $nb_coms->rowCount();
			// echo "<div class=cross><a href='delete_post.php><img src='data/cross-296507_640.png'></a></div>";

			echo "<div class='post'>";
			echo "<img src='".$image."' height='300' width='340px'>";
			echo "<div class='like' ><a href='likes.php?id=".$id."'>like (".$likes.")</a></div>";
			echo "<div class='comment'><a href='comments.php?id=".$id."&usr=".$img_user."'>comment (".$coms.")</a></div>";
			if (isset($_SESSION['login']) AND $_SESSION['login'] == $img_user)
				echo "<div class='delete'><a href='delete_post.php?id=".$id."&usr=".$img_user."'>Supprimer</a></div>";
			echo "</div>";
	
	}	
	//Pagination link
	echo "<br>";
	$range = 3;
	echo "<div id='pagination'>";
	if ($currentpage > 1){
		//show link to go to page 1 <<
		echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=1'> << </a>";
		$prevpage = $currentpage - 1;
		echo "<a href='{$_SERVER['PHP_SELF']}'?currentpage=$prevpage'> < </a>";
	}


	//loop to show pages arounf currentpage
	for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++)
	{
		//if valide page number
		if (($x > 0) && ($x <= $totalpages))
		{
			//if were on current page
			if ($x == $currentpage)
				echo "[<b>$x<b>]";
			else 
				echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$x'> $x </a>";
		}
	}

	//if not on last page show forward and last page
	if ($currentpage != $totalpages)
	{
		$nextpage = $currentpage + 1;
		//forward link for the next page 
		echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'> > </a>";
		//for the last page
		echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'> >> </a>";
	}
	echo "</div>";
	?>

<html>
<head>
	<meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
<div class="header">

	<?php if     ($_SESSION['loggedin'] = true)
 echo ('<a href="membre.php">Retour</a>');
 else 
 echo ('<a href="membre.php">Retour</a>');
?>
</div>
	<title>Camagru</title>
	</head>

<body>
			
</body>
<div class="footer"></div>

</html>