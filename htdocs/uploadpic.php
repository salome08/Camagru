<?php
	session_start();
  ini_set('display_errors', 1);
	if (!isset($_SESSION['login']))
	{
		header('Location: index.php');
		exit();
	}

  function resize_image($image, $max_resolution)
  {
    $original_image = imagecreatefromjpeg($image);
    $original_width = imagesx($original_image);
    $original_height = imagesy($original_image);
    $ratio = $max_resolution / $original_width;
    $new_width = $max_resolution;
    $new_height = $original_height * $ratio;

    if ($new_height > $max_resolution){
      $ratio = $max_resolution / $original_height;
      $new_height = $max_resolution;
      $new_width = $original_width * $ratio;
    }

    if ($original_image)
    {
      $new_image = imagecreatetruecolor($new_width, $new_height);
      imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
      imagejpeg($new_image, $image, 500);
    }
  }

  require_once('config/database.php');
  $msg = '';
  if (isset($_POST['upload']))
  {

    if (isset($_FILES['image']) && $_FILES['image']['type'] == 'image/jpeg')
    {
      $target = "images/".basename($_FILES['image']['name']);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));
      $check = getimagesize($_FILES['image']['tmp_name']);
      if ($check !== false)
      {
        $uploadOk = 1;
      }
      else
        $uploadOk = 0;
      if ($_FILES['image']['size'] > 5000000)
      {
        $uploadOk = 0;
      }
      if ($imageFileType != 'jpg' AND $imageFileType != 'jpeg')
      {
        $uploadOk = 0;
      }
      
      if ($uploadOk == 0)
      {
        $msg = "ERROR : Wrong format";
      }
      else 
      {
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target))
           $image = "images/" . $_FILES['image']['name'];
            resize_image($image, "250");
       }
      // $db = dbConnect();  
      
    }
    else 
    $msg = "Error: wrong format upload.";

      // echo "<img id='picuploaded' src='".$image."' height='300' width='340px'>";

      // $req = $db->prepare("INSERT INTO pictures (image, user) VALUES (:image, :user)");
      // $req->bindParam(':image', $image);
      // $req->bindParam(':user', $_SESSION['login']);
      // $req->execute();
  }
?>

<!DOCTYPE html>
<html>  <link rel="stylesheet" href="style.css" />
<head>
  <div class="header">

    <title>Upload </title> 
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

<div id="divupload">
<pre id="preLog">Chargement…</pre>
<div id="overlay"></div>

<canvas id="mycanvas" width="150" height="200"></canvas>
<?php 
  if(isset($image))
  {
    echo "<img id='picuploaded' src='".$image."'>";
  }
    echo ($msg);
?>
<form id="uploadform" method="post" action="#" enctype="multipart/form-data">
      <input type="hidden" name="size" value="1000000">
      <div>
        <input type="file" name="image" accept=".jpg, .jpeg, .png">
      </div>
      <div>
        <input type="submit" name="upload" value="Show Image">

      </div>
      <input type="button" id="buttonPost" disabled="true" value="keep pic" onclick="savetodb()" />
    </form>
     


</div>
<div id="result"></div>
<script type="text/javascript" src="webcam.js"></script>
</body>
<div class="footer"></div>
</html>