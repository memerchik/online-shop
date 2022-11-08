<?php
setcookie('CookieUserName', $_SESSION['UserName'], time()-3600,"/");
session_destroy();
header('Location: ../index.php');
die();
?>