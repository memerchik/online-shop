<?php
include "dbConnection.php";
mysqli_select_db($connection, "eshopzab");
ini_set('session.save_path', '../../session/');
session_start();
if(!isset($_COOKIE['CookieUserName'])||!isset($_POST['productIDchange'])||!isset($_POST['productAmount'])){
    echo "error;";
    die();
}
if(!is_numeric($_POST['productIDchange'])||!is_numeric($_POST['productAmount'])){
    echo "error";
    die();
}
if($_POST['productAmount']>9||$_POST['productAmount']<1){
    echo "error";
    die();
}
$productID=$_POST['productIDchange'];
$checkIfProductExists=$connection->prepare("SELECT COUNT(*) AS cnt FROM Products WHERE ProductID=?");
$checkIfProductExists->bind_param("s",$productID);
$checkIfProductExists->execute();
$aa=$checkIfProductExists->get_result();
$aaa=$aa->fetch_assoc();
if($aaa['cnt']==0){
    echo "product doesn't exist";
    die();
}
$arr=$_SESSION['ShoppingCart'];
$arr[$_POST['productIDchange']]=$_POST['productAmount'];
$_SESSION['ShoppingCart']=$arr;
$serializeSh=serialize($_SESSION['ShoppingCart']);
$insertIntoDb=$connection->prepare("UPDATE Customers SET ShoppingCartContent=? WHERE UserID=?");
$insertIntoDb->bind_param("ss",$serializeSh, $_SESSION['UserUserID']);
$insertIntoDb->execute();
?>