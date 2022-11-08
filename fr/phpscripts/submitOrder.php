<?php
include "dbConnection.php";
mysqli_select_db($connection, "eshopzab");
ini_set('session.save_path', '../../session/');
session_start();
if(!isset($_COOKIE['CookieUserName'])||!isset($_POST['check'])||count($_SESSION['ShoppingCart'])<1){
    echo "error";
    die();
}
$date=date('Y-m-d H:i:s');
$insertInto=$connection->prepare("INSERT INTO Orders(`UserID`,`OrderDate`,`OrderStatus`) VALUES (?,?,'Submitted')");
$insertInto->bind_param("ss",$_SESSION['UserUserID'], $date);
$insertInto->execute();
$SelectOrderID=$connection->prepare("SELECT OrderID FROM Orders WHERE UserID=? AND OrderDate=?");
$SelectOrderID->bind_param("ss",$_SESSION['UserUserID'], $date);
$SelectOrderID->execute();
$oaa=$SelectOrderID->get_result();
$orderID=$oaa->fetch_assoc();
foreach($_SESSION['ShoppingCart'] as $key=>$value){
    $qq=$connection->prepare("INSERT INTO OrdersItemsList(`OrderID`,`ItemID`,`ItemQuantity`) VALUES (?,?,?)");
    $qq->bind_param("sss", $orderID['OrderID'],$key,$value);
    $qq->execute();
}
unset($_SESSION['ShoppingCart']);
$_SESSION['ShoppingCart']=[];
$serializeSh=serialize($_SESSION['ShoppingCart']);
$insertIntoDb=$connection->prepare("UPDATE Customers SET ShoppingCartContent=? WHERE UserID=?");
$insertIntoDb->bind_param("ss",$serializeSh, $_SESSION['UserUserID']);
$insertIntoDb->execute();
echo "success<next>".$orderID['OrderID'];
?>