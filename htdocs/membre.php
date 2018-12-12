<?php
	session_start();
	if (!isset($_SESSION['login']))
	{
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE html>
<html>  <link rel="stylesheet" href="style.css" />
<head>
  <div class="header">

    <title>Espace membre  </title> 
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
</head>
<body>
  Bienvenue <?php echo htmlentities(trim($_SESSION['login'])); ?> !<br />
  
<a href="deconnexion.php">Déconnexion</a>
<a href="preference.php">Préferences</a>
<a href="gallery.php">Gallery</a>



<div class="filters">
   <button onclick="overlay(this.id)" id="1"> <img id="imagepng" src="data/1.png";></button>
   <button onclick="overlay(this.id)" id="2"> <img id="imagepng" src="data/2.png";></button>
   <button onclick="overlay(this.id)" id="3"> <img id="imagepng" src="data/3.png";></button>
   <button onclick="overlay(this.id)" id="4"> <img id="imagepng" src="data/4.png";></button>
   <button onclick="overlay(this.id)" id="5"> <img id="imagepng" src="data/5.png";></button>
   <button onclick="overlay(this.id)" id="6"> <img id="imagepng" src="data/6.png";></button><br>
</div>  

<?php
  require_once('config/database.php');
  $db = dbConnect();
  $aff = $db->prepare('SELECT image FROM pictures ORDER BY id DESC LIMIT 3');
  $aff->execute();
  echo "<div id='gallery'>";
  while($row = $aff->fetch())
  {
      $image = $row['image'];
      echo "<img src='".$image."'height='100' width='140'>";
  } 
  echo "</div>";

?>


<div class="cam">
<pre id="preLog">Chargement…</pre>
<div id="overlay"></div>

<video id="video" autoplay="autoplay" width="30%"></video><canvas id="canvas"></canvas>
<input type="button" id="buttonSnap" value="Prendre une photo" disabled="disabled" onclick="snapshot()" />
<input type="button" id="buttonPost" value="keep pic" onclick="post()" />
<a href="uploadpic.php"><input type="button" id="buttonUpload" value="Upload"/></a>
</div>
<div id="result"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



<script type="text/javascript" src="webcam.js"></script>
</body>
<div class="footer"></div>
</html>