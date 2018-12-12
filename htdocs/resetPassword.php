<?php
session_start();
require_once('config/database.php');
if (isset($_POST['envoyer']) && $_POST['envoyer'] == 'Envoyer')
  {
    if (isset($_POST['newPassword']) && !empty($_POST['newPassword']) )
    {
      $login = $_GET['log'];
      $cle = $_GET['cle'];
      // $newPassword = $_POST['newPassword'];
      $newPassword = hash('whirlpool', $_POST['newPassword']);

       
      $db = dbConnect();
      $req = $db->prepare("SELECT cle FROM user WHERE login like :login ");
      if($req->execute(array(':login' => $login)) && $row = $req->fetch())
        {
          $clebdd = $row['cle'];	
           if($cle == $clebdd)
             {	
                 $req = $db->prepare("UPDATE user SET password = :password WHERE login like :login ");
               $req->bindParam(':password', $newPassword);
                $req->bindParam(':login', $login);
                $req->execute();
                $erreur = 'Votre mot de passe a été changé';
             }
           else
             {
                $erreur = 'Erreur ! mot de passe non changé';
             }
        }
      }
      else 
      $erreur = 'Un champ est vide';
    }

?>

<html>
<head>
  <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
<div class="header"></div>
  <title>Camagru</title>
  </head>

<body>
<fieldset>
<!-- <div class="content"> -->
  <legend> Reinitialiser mot de passe :</legend>
  <form action="#" method="post">
  
  <label for="newPassword">Nouveau mot de passe :</label>
    <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"   required title="6 caractères, un chiffre et 1 maj" type="password" name="newPassword" value="<?php if (isset($_POST['newPassword'])) echo htmlentities(trim($_POST['newPassword'])); ?>"><br />

  </br><input type="submit" name="envoyer" value="Envoyer"></br>
  </form>
  <?php
  if (isset($erreur)) echo '<br /><br />',$erreur;
  ?>
</fieldset>

  <a href="logForm.php">Vous connectez</a></br>



<div class="footer"></div>
</body>
</html>