<?php
session_start();
ini_set('display_errors', 1);
	require_once('config/database.php');
	
	$msg = "";
	if (isset($_POST['upload'])){

		$target = "images/".basename($_FILES['image']['name']);
			$db = dbConnect();	
			$image = "images/" . $_FILES['image']['name'];
			$text = $_POST['text'];

			echo "<img src='".$image."' width='30%'>";

			$req = $db->prepare("INSERT INTO pictures (image, text, user) VALUES (:image, :text, :user)");
			$req->bindParam(':image', $image);
			$req->bindParam(':text', $text);
			$req->bindParam(':user', $_SESSION['login']);
			$req->execute();

			if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
				$msg = "Image uploaded successfully !";
			}
			else {
				$msg = "Problem uploading image.. ";
			}
		echo ($msg);
	}

?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
<div class="header">
<a href="membre.php">Retour</a>
</div>
	<title>Camagru</title>
	</head>

<body>
	<div id="content">

		<form method="post" action="uploadpic.php" enctype="multipart/form-data">
			<input type="hidden" name="size" value="1000000">
			<div>
				<input type="file" name="image" accept=".jpg, .jpeg, .png">
			</div>
			<div>
				<textarea name="text" cols="40" rows="4" placeholder="say something..."></textarea>
			</div>
			<div>
				<input type="submit" name="upload" value="Upload Image">
			</div>
		</form>
	</div>

</body>
<div class="footer"></div>

</html>