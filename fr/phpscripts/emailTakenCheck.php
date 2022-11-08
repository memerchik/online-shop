<?php
ini_set('session.save_path', '../../session/');
session_start();
include "dbConnection.php";
mysqli_select_db($connection, "eshopzab");
$email=$_POST['email'];
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