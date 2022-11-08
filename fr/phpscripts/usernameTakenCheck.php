<?php
include "dbConnection.php";
mysqli_select_db($connection, "eshopzab");
$username=$_POST['username'];
$qq=$connection->prepare("SELECT COUNT(*) AS cnt FROM Customers WHERE Username=?");
$qq->bind_param("s", $username);
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