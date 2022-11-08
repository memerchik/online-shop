<?php
include "dbConnection.php";
mysqli_select_db($connection, "eshopzab");

if(empty($_POST['UserUsername'])||empty($_POST['UserEmail'])||empty($_POST['UserName'])||empty($_POST['UserPassword'])||empty($_POST['UserRepeatPassword'])){
    echo "emptyField";
    die();
}
$UserUsername=$_POST['UserUsername'];
$UserEmail=$_POST['UserEmail'];
$UserName=$_POST['UserName'];
$UserPassword=$_POST['UserPassword'];
$UserRepeatPassword=$_POST['UserRepeatPassword'];
if($UserRepeatPassword!=$UserPassword){
    echo "differentPasswords";
    die();
}
$pattern_email='/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
$pattern_name='/^[a-zA-Z]+$/';
$pattern_username='/^[a-zA-Z0-9]+$/';
$pattern_passwordNum='/\d/';
$pattern_passwordSpec='/[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]+/';
if(!preg_match($pattern_email, $UserEmail)||!preg_match($pattern_name,$UserName)||!preg_match($pattern_username,$UserUsername)||!preg_match($pattern_passwordNum,$UserPassword)||!preg_match($pattern_passwordSpec,$UserPassword)||strlen($UserPassword)<8||strlen($UserUsername)<5||strlen($UserName)<2){
    echo "patternNotMatch";
    die();
}
$qq=$connection->prepare("SELECT COUNT(*) AS cnt FROM Customers WHERE Email=?");
$qq->bind_param("s", $UserEmail);
$qq->execute();
$qqq=$qq->get_result();
$qqqq=$qqq->fetch_assoc();
if($qqqq['cnt']>0){
    echo "emailTaken";
    die();
}
$qq=$connection->prepare("SELECT COUNT(*) AS cnt FROM Customers WHERE Username=?");
$qq->bind_param("s", $UserUsername);
$qq->execute();
$qqq=$qq->get_result();
$qqqq=$qqq->fetch_assoc();
if($qqqq['cnt']>0){
    echo "usernameTaken";
    die();
}
$date=date("Y-m-d");
$UserPassword=md5($UserPassword);
$def="default.jpg";
$qq=$connection->prepare("INSERT INTO Customers (`Username`,`Email`,`Name`,`Password`,`Status`, `RegisterDate`, `ProfilePicName`) VALUES (?, ?, ?, ?, 0, ?, ?)");
$qq->bind_param("ssssss", $UserUsername, $UserEmail, $UserName, $UserPassword, $date, $def);
$qq->execute();
sleep(2);
ini_set('session.save_path', '../../session/');
session_start();
$userID=$connection->prepare("SELECT UserID FROM Customers WHERE Username=?");
$userID->bind_param("s",$UserUsername);
$userID->execute();
$IDD=$userID->get_result();
$ID=$IDD->fetch_assoc();
$_SESSION['UserUserID']=$ID['UserID'];
$_SESSION['UserUsername']=$UserUsername;
$_SESSION['UserName']=$UserName;
$_SESSION['UserEmail']=$UserEmail;
$_SESSION['UserSurname']="";
$_SESSION['UserStatus']=0;
$_SESSION['UserRegisterDate']=$date;
$_SESSION['UserBirthDate']="";
$_SESSION['UserPermissionName']="Customer";
$_SESSION['UserAvatarName']=$def;
$_SESSION['lang']="ua";
$_SESSION['ShoppingCart']=[];
setcookie('CookieUserName', $UserName, time()+3600,"/");
echo "success;".$_SESSION['UserName'];
?>