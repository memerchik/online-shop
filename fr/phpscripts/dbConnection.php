<?php
$name = "localhost";
$user = "root";
$pwd = "";
$connection = mysqli_connect($name, $user, $pwd);
if(!$connection){
    die();
}
?>