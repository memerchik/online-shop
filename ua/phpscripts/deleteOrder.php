<?php
include "dbConnection.php";
ini_set('session.save_path', '../../session/');
session_start();
mysqli_select_db($connection, "eshopzab");
if(!isset($_COOKIE['CookieUserName'])||empty($_POST['IDtoDelete'])||$_SESSION['UserStatus']<1){
    echo "error";
    die();
}
$orderID=$_POST['IDtoDelete'];
$checkIfOrderExists=$connection->prepare("SELECT MAX(OrderID) AS cnt FROM Orders");
$checkIfOrderExists->execute();
$aa=$checkIfOrderExists->get_result();
$aaa=$aa->fetch_assoc();
if($aaa['cnt']<$orderID){
    echo "error1<next>".$_POST['IDtoDelete'];
    die();
}
$deleteOrder=$connection->prepare("DELETE FROM OrdersItemsList WHERE OrderID=?");
$deleteOrder->bind_param("s", $_POST['IDtoDelete']);
$deleteOrder->execute();

$deleteOrder=$connection->prepare("DELETE FROM Orders WHERE OrderID=?");
$deleteOrder->bind_param("s", $_POST['IDtoDelete']);
$deleteOrder->execute();

echo "success<next>".$_POST['IDtoDelete'];
?>