<?php
include "dbConnection.php";
ini_set('session.save_path', '../../session/');
session_start();
mysqli_select_db($connection, "eshopzab");
if(empty($_POST['Email'])||!isset($_COOKIE['CookieUserName'])){
    die();
}
$email=$_POST['Email'];
if($email==$_SESSION['UserEmail']){
    echo "free";
    die();
}
$qq=$connection->prepare("SELECT COUNT(*) AS cnt FROM Customers WHERE Email=?");
$qq->bind_param("s", $email);
$qq->execute();
$qqq=$qq->get_result();
$qqqq=$qqq->fetch_assoc();
if($qqqq['cnt']==0){
    echo "free";
}
else if($qqqq['cnt']>0){
    echo "taken";
}
?>