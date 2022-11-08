<?php
include "dbConnection.php";
ini_set('session.save_path', '../../session/');
session_start();
mysqli_select_db($connection, "eshopzab");
if(!isset($_COOKIE['CookieUserName'])||empty($_POST['ID'])||empty($_POST['Status'])||$_SESSION['UserStatus']<1){
    echo "error<next>".$_POST['ID'];
    die();
}
if($_POST['Status']!="Submitted"&&$_POST['Status']!="Confirmed"&&$_POST['Status']!="In Delivery"&&$_POST['Status']!="Delivered"){
    echo "error<next>".$_POST['ID'];
    die();
}
$changeStatus=$connection->prepare("UPDATE Orders SET OrderStatus=? WHERE OrderID=?");
$changeStatus->bind_param("ss",$_POST['Status'],$_POST['ID']);
$changeStatus->execute();
echo "success<next>".$_POST['ID'];
?>