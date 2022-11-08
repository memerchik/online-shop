<?php
sleep(2);
include "dbConnection.php";
ini_set('session.save_path', '../../session/');
session_start();
mysqli_select_db($connection, "eshopzab");
if(empty($_POST['Password'])||!isset($_COOKIE['CookieUserName'])){
    echo "emptyerror";
    die();
}
$oldpswd=md5($_POST['Password']);
$qq=$connection->prepare("SELECT COUNT(*) AS cnt FROM Customers WHERE Username=? AND Password=?");
$qq->bind_param("ss", $_SESSION['UserUsername'], $oldpswd);
$qq->execute();
$qqq=$qq->get_result();
$qqqq=$qqq->fetch_assoc();
if($qqqq['cnt']>0){
    echo "correct";
    die();
}
else{
    echo "incorrect";
    die();
}
?>