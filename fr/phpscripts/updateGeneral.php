<?php
include "dbConnection.php";
ini_set('session.save_path', '../../session/');
session_start();
mysqli_select_db($connection, "eshopzab");
sleep(2);
if(!isset($_COOKIE['CookieUserName'])){
    echo "ErrorUpdate";
    die();
}
if(!isset($_POST['UserName'])||!isset($_POST['UserSurname'])||!isset($_POST['UserEmail'])||!isset($_POST['UserBirthDate'])){
    echo "ErrorUpdate";
    die();
}
$newName=$_POST['UserName'];
$newSurname=$_POST['UserSurname'];
$newEmail=$_POST['UserEmail'];
$newBirthDate=$_POST['UserBirthDate'];
$pattern_email='/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
$pattern_name='/^[a-zA-Z]+$/';
if(!preg_match($pattern_email, $newEmail)||!preg_match($pattern_name, $newName)||!preg_match($pattern_name, $newSurname)||strlen($newName)<2||strlen($newSurname)<2||strlen($newBirthDate)!=10){
    echo "ErrorUpdate";
    die();
}
//date
$year=substr($newBirthDate, 0, 4);
if($year==""||!is_numeric($year)){
    echo "ErrorUpdate";
    die();
}
$month=substr($newBirthDate, 5, 2);
if($month==""||!is_numeric($month)){
    echo "ErrorUpdate";
    die();
}
$day=substr($newBirthDate, 8, 2);
if($day==""||!is_numeric($day)){
    echo "ErrorUpdate";
    die();
}
$valid=checkdate($month,$day,$year);
if($valid!=1){
    echo "ErrorUpdate";
    die();
}
$newBirthDate=$year."-".$month."-".$day;
$date=date("Y-m-d");
if($newBirthDate>=$date){
    echo "ErrorUpdate";
    die();
}
$qq=$connection->prepare("SELECT COUNT(*) AS cnt FROM Customers WHERE Email=?");
$qq->bind_param("s", $email);
$qq->execute();
$qqq=$qq->get_result();
$qqqq=$qqq->fetch_assoc();
if($qqqq['cnt']!=0){
    echo "ErrorUpdate";
    die();
}
$q=$connection->prepare("UPDATE Customers SET Name=?, Surname=?, Email=?, BirthDate=? WHERE Username=?");
$q->bind_param("sssss", $newName, $newSurname, $newEmail, $newBirthDate, $_SESSION['UserUsername']);
$q->execute();
$_SESSION['UserName']=$newName;
$_SESSION['UserSurname']=$newSurname;
$_SESSION['UserEmail']=$newEmail;
$_SESSION['UserBirthDate']=$newBirthDate;
echo "SuccessUpdate";
?>