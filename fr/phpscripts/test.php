<?php
include "dbConnection.php";
ini_set('session.save_path', '../../session/');
session_start();
mysqli_select_db($connection, "eshopzab");
$lastInsert=$connection->prepare("SELECT LAST_INSERT_ID() AS ls");
$lastInsert->execute();
$ll=$lastInsert->get_result();
$lll=$ll->fetch_assoc();
echo $lll['ls'];
?>