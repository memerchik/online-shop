<?php
include "dbConnection.php";
mysqli_select_db($connection, "eshopzab");
ini_set('session.save_path', '../../session/');
session_start();
if(!isset($_COOKIE['CookieUserName'])||!isset($_POST['ProductID'])||!is_numeric($_POST['ProductID'])){
    echo "error;".$_POST['ProductID'];
    die();
}
//Check if product exists
$productID=$_POST['ProductID'];
$checkIfProductExists=$connection->prepare("SELECT COUNT(*) AS cnt FROM Products WHERE ProductID=?");
$checkIfProductExists->bind_param("s",$productID);
$checkIfProductExists->execute();
$aa=$checkIfProductExists->get_result();
$aaa=$aa->fetch_assoc();
if($aaa['cnt']==0){
    echo "product doesn't exist";
    die();
}
//Add to cart
$arr=$_SESSION['ShoppingCart'];
$arr[$productID]=1;
$_SESSION['ShoppingCart']=$arr;
$serializeSh=serialize($_SESSION['ShoppingCart']);
$insertIntoDb=$connection->prepare("UPDATE Customers SET ShoppingCartContent=? WHERE UserID=?");
$insertIntoDb->bind_param("ss",$serializeSh, $_SESSION['UserUserID']);
$insertIntoDb->execute();

$qq=$connection->prepare("SELECT ProductTitle, Price, Picture1 FROM Products JOIN Pictures USING(ProductID) WHERE ProductID=?");
$qq->bind_param("s", $productID);
$qq->execute();
$qqq=$qq->get_result();
$qqqq=$qqq->fetch_assoc();
$cc=$connection->prepare("SELECT Description FROM Description WHERE ProductID=? AND Language=?");
$cc->bind_param("ss", $productID, $_SESSION['lang']);
$cc->execute();
$ccc=$cc->get_result();
$description=$ccc->fetch_assoc();
echo "success<next>".$productID."<next>".$qqqq['ProductTitle']."<next>".$qqqq['Price']."<next>".$qqqq['Picture1']."<next>".$description['Description'];
?>