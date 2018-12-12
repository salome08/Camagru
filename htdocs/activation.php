<?php
ini_set('display_errors', 1);
require_once('config/database.php');
if(isset($_GET['log'], $_GET['cle']) AND !empty($_GET['cle']) AND !empty($_GET['log']))
{ 
  $login = $_GET['log'];
  $cle = $_GET['cle'];

  $db = dbConnect();
  $req = $db->prepare("SELECT cle,actif FROM user WHERE login like :login ");
  if($req->execute(array(':login' => $login)) && $row = $req->fetch())
    {
      $clebdd = $row['cle'];  
      $actif = $row['actif'];
    }
   
  if($actif == '1') 
    {
       echo "Votre compte est déjà actif !";
    }
  else
    {
       if($cle == $clebdd)
         {  
             $req = $db->prepare("UPDATE user SET actif = 1 WHERE login like :login ");
            $req->bindParam(':login', $login);
            $req->execute();
            echo "Votre compte a bien été activé !";
            
         }
       else
         {
            echo "Erreur ! Votre compte ne peut être activé...";
         }
  }
}
  else echo "Page web innaccessible";

?>