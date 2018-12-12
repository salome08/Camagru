<?php
function send_confirmation_mail($mail, $username, $cle) {
  $subject = "[CAMAGRU] - Email verification";
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
  $headers .= 'From: <shazan@student.42.fr>' . "\r\n";
  $message = '
  <html>
    <head>
      <title>' . $subject . '</title>
    </head>
    <body>
      Hello ' . htmlspecialchars($username) . ' </br>
      To finalyze your subscribtion please click the link below </br>
      <a href="http://127.0.0.1:8080/demo/activation.php?log='. $username.'&cle=' . $cle . '">Verify my email</a>
    </body>
  </html>
  ';
  // mail($mail, $subject, $message, $headers);

   $to      = $mail;
 // $subject = 'le sujet';
 // $message = 'Bonjour !';
 // $headers = 'From: salome.hazan.sh@gmail.com';

 $res = mail($to, $subject, $message, $headers);
}

function send_forget_password($mail, $username, $cle)
{
   $subject = "[CAMAGRU] - Forget your password";
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
  $headers .= 'From: <shazan@student.42.fr>' . "\r\n";
  $message = '
  <html>
    <head>
      <title>' . $subject . '</title>
    </head>
    <body>
      Hello ' . htmlspecialchars($username) . ' </br>
      Reset you password here : </br>
      <a href="http://127.0.0.1:8080/demo/resetPassword.php?log='. $username.'&cle=' . $cle . '">Reset password</a>
    </body>
  </html>
  ';
  mail($mail, $subject, $message, $headers);
}

function send_commentaire_mail($mail, $login_recepteur, $login_emeteur) {
   $to      = $mail;
 $subject = "[CAMAGRU] - You have a new comment";
 $message = 'Bonjour '.$login_recepteur. '!, l\'utilisateur ' .$login_emeteur.' a commenté votre photo';
 $headers = 'From: <shazan@student.42.fr>' . "\r\n" ;

 $res = mail($to, $subject, $message, $headers);
}

?>