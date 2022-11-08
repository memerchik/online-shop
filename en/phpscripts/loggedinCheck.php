<?php
if(!isset($_COOKIE['CookieUserName'])){
    header('Location: ../index.php');
    die();
}
?>