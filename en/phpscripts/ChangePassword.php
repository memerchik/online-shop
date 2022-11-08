<?php
sleep(2);
include "dbConnection.php";
ini_set('session.save_path', '../../session/');
session_start();
mysqli_select_db($connection, "eshopzab");
if(empty($_POST['OldPassword'])||empty($_POST['NewPassword'])||!isset($_COOKIE['CookieUserName'])){
    echo "error";
    die();
}
$oldpswd=md5($_POST['OldPassword']);
$qq=$connection->prepare("SELECT COUNT(*) AS cnt FROM Customers WHERE Username=? AND Password=?");
$qq->bind_param("ss", $_SESSION['UserUsername'], $oldpswd);
$qq->execute();
$qqq=$qq->get_result();
$qqqq=$qqq->fetch_assoc();
if($qqqq['cnt']<=0){
    echo "error";
    die();
}
$newpswd=$_POST['NewPassword'];
$pattern_passwordNum='/\d/';
$pattern_passwordSpec='/[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]+/';
if(!preg_match($pattern_passwordNum, $newpswd)||!preg_match($pattern_passwordSpec, $newpswd)||strlen($newpswd)<8){
    echo "error";
    die();
}
$newpswd=md5($newpswd);
$q=$connection->prepare("UPDATE Customers SET Password=? WHERE Username=?");
$q->bind_param("ss", $newpswd, $_SESSION['UserUsername']);
$q->execute();
echo "successChange";
?>