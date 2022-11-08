<?php
include "dbConnection.php";
ini_set('session.save_path', '../../session/');
session_start();
mysqli_select_db($connection, "eshopzab");
if(!isset($_COOKIE['CookieUserName'])||$_FILES['file']['name'] == ''){
    echo "error";
    die();
}
if($_FILES['file']['name'] != ''){
    $test = explode('.', $_FILES['file']['name']);
    $extension = end($test);
    if($extension=="jpg"||$extension=="png"||$extension=="jpeg"){
        $name = $_SESSION['UserUsername'].rand(1000000,9999999).'.'.$extension;

        //Delete old file
        $old=$connection->prepare("SELECT ProfilePicName FROM Customers WHERE Username=?");
        $old->bind_param("s", $_SESSION['UserUsername']);
        $old->execute();
        $oldd=$old->get_result();
        $resultOld=$oldd->fetch_assoc();
        $path="../../userpictures/";
        if($resultOld['ProfilePicName']!=""&&$resultOld['ProfilePicName']!="default.jpg"){
        $oldName=$resultOld['ProfilePicName'];
        $filefinal=$path.$oldName;
        unlink($filefinal);
        }
        //Create new
        $insert=$connection->prepare("UPDATE Customers SET `ProfilePicName` = ? WHERE Username = ?");
        $insert->bind_param("ss", $name, $_SESSION['UserUsername']);
        $insert->execute();
        $location = $path.$name;
        move_uploaded_file($_FILES['file']['tmp_name'], $location);
        $_SESSION['UserAvatarName']=$name;
        echo "successImg".$name;
        die();
    }
    else{
        echo "extension error";
        die();
    }
    
}
?>