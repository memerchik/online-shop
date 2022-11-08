<?php
include "dbConnection.php";
mysqli_select_db($connection, "eshopzab");
sleep(2);

if(empty($_POST['UsernameEmail'])||empty($_POST['Password'])){
    echo "Empty fields";
    die();
}
$pattern_email='/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
$pattern_username='/^[a-zA-Z0-9]+$/';
$UserEmailUsername=$_POST['UsernameEmail'];
$UserPassword=$_POST['Password'];
if(!preg_match($pattern_email, $UserEmailUsername)&&!preg_match($pattern_username, $UserEmailUsername)){
    echo "Incorrect format";
    die();
}
$UserPassword=md5($UserPassword);
if(preg_match($pattern_email, $UserEmailUsername)){
    $qq=$connection->prepare("SELECT COUNT(*) AS cnt FROM Customers WHERE Email=? AND Password=?");
    $qq->bind_param("ss", $UserEmailUsername, $UserPassword);
    $qq->execute();
    $qqq=$qq->get_result();
    $qqqq=$qqq->fetch_assoc();
    if($qqqq['cnt']>0){
        ini_set('session.save_path', '../../session/');
        session_start();
        $_SESSION['UserEmail']=$UserEmailUsername;
        $email=$connection->prepare("SELECT `customers`.`UserID`, `customers`.`ShoppingCartContent`, `customers`.`Username`, `customers`.`Name`, `customers`.`Status`, `customers`.`ProfilePicName`,`customers`.`Surname`, `customers`.`RegisterDate`, `customers`.`BirthDate`, `permissions`.`PermissionName` FROM `customers` LEFT JOIN `permissions` ON `customers`.`Status` = `permissions`.`PermissionID` WHERE Email=? AND Password=?");
        $email->bind_param("ss", $UserEmailUsername, $UserPassword);
        $email->execute();
        $emaill=$email->get_result();
        $resultEmail=$emaill->fetch_assoc();
        $_SESSION['UserUserID']=$resultEmail['UserID'];
        $_SESSION['UserRegisterDate']=$resultEmail['RegisterDate'];
        $_SESSION['UserBirthDate']=$resultEmail['BirthDate'];
        $_SESSION['UserUsername']=$resultEmail['Username'];
        $_SESSION['UserStatus']=$resultEmail['Status'];
        $_SESSION['UserName']=$resultEmail['Name'];
        $_SESSION['UserSurname']=$resultEmail['Surname'];
        $_SESSION['UserPermissionName']=$resultEmail['PermissionName'];
        $_SESSION['UserAvatarName']=$resultEmail['ProfilePicName'];
        $_SESSION['lang']="en";
        if($resultEmail['ShoppingCartContent']!=""){
            $_SESSION['ShoppingCart']=unserialize($resultEmail['ShoppingCartContent']);
        }
        else{
            $_SESSION['ShoppingCart']=[];
        }
        setcookie('CookieUserName', $resultEmail['Name'], time()+3600,"/");
        echo "success;".$_SESSION['UserName'];
        die();
    }
    else{
        echo "WrongPass";
        die();
    }
}
if(preg_match($pattern_username, $UserEmailUsername)){
    $qq=$connection->prepare("SELECT COUNT(*) AS cnt FROM Customers WHERE Username=? AND Password=?");
    $qq->bind_param("ss", $UserEmailUsername, $UserPassword);
    $qq->execute();
    $qqq=$qq->get_result();
    $qqqq=$qqq->fetch_assoc();
    if($qqqq['cnt']>0){
        ini_set('session.save_path', '../../session/');
        session_start();
        $_SESSION['UserUsername']=$UserEmailUsername;
        $email=$connection->prepare("SELECT `customers`.`UserID`, `customers`.`ShoppingCartContent`, `customers`.`Email`, `customers`.`Name`, `customers`.`Status`, `customers`.`Surname`, `customers`.`ProfilePicName`, `customers`.`RegisterDate`, `customers`.`BirthDate`, `permissions`.`PermissionName` FROM `customers` LEFT JOIN `permissions` ON `customers`.`Status` = `permissions`.`PermissionID` WHERE Username=? AND Password=?");
        $email->bind_param("ss", $UserEmailUsername, $UserPassword);
        $email->execute();
        $emaill=$email->get_result();
        $resultEmail=$emaill->fetch_assoc();
        $_SESSION['UserUserID']=$resultEmail['UserID'];
        $_SESSION['UserRegisterDate']=$resultEmail['RegisterDate'];
        $_SESSION['UserBirthDate']=$resultEmail['BirthDate'];
        $_SESSION['UserEmail']=$resultEmail['Email'];
        $_SESSION['UserStatus']=$resultEmail['Status'];
        $_SESSION['UserName']=$resultEmail['Name'];
        $_SESSION['UserSurname']=$resultEmail['Surname'];
        $_SESSION['UserPermissionName']=$resultEmail['PermissionName'];
        $_SESSION['UserAvatarName']=$resultEmail['ProfilePicName'];
        $_SESSION['lang']="en";
        if($resultEmail['ShoppingCartContent']!=""){
        $_SESSION['ShoppingCart']=unserialize($resultEmail['ShoppingCartContent']);
        }
        else{
            $_SESSION['ShoppingCart']=[];
        }
        setcookie('CookieUserName', $resultEmail['Name'], time()+3600,"/");
        echo "success;".$_SESSION['UserName'];
        die();
    }
    else{
        echo "WrongPass";
        die();
    }
}
?>