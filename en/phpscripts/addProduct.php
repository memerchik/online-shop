<?php
sleep(2);
include "dbConnection.php";
ini_set('session.save_path', '../../session/');
session_start();
mysqli_select_db($connection, "eshopzab");
if(empty($_POST['Title'])||empty($_POST['DescriptionEN'])||empty($_POST['DescriptionUA'])||empty($_POST['DescriptionFR'])||empty($_POST['Price'])||empty($_POST['PriceOld'])||($_POST['IsOnDiscount']!=1&&$_POST['IsOnDiscount']!=0)||!isset($_COOKIE['CookieUserName'])){
    echo "error";
    die();
}
$date=date("Y-m-d");    
$createPD=$connection->prepare("INSERT INTO Products(ProductTitle, Price, OldPrice, IsOnDiscount, dateAdded, userAdded) VALUES(?,?,?,?,?,?)");
$createPD->bind_param("ssssss", $_POST['Title'], $_POST['Price'], $_POST['PriceOld'], $_POST['IsOnDiscount'], $date, $_SESSION['UserUserID']);
$createPD->execute();
$lastInsert=$connection->prepare("SELECT LAST_INSERT_ID() AS ls");
$lastInsert->execute();
$ll=$lastInsert->get_result();
$lll=$ll->fetch_assoc();
$_SESSION['AddProductID']=$lll['ls'];
$en="en";
$addDescEN=$connection->prepare("INSERT INTO Description(ProductID, Language, Description) VALUES (?,?,?)");
$addDescEN->bind_param("sss",$lll['ls'], $en, $_POST['DescriptionEN']);
$addDescEN->execute();
$ua="ua";
$addDescUA=$connection->prepare("INSERT INTO Description(ProductID, Language, Description) VALUES (?,?,?)");
$addDescUA->bind_param("sss",$lll['ls'], $ua, $_POST['DescriptionUA']);
$addDescUA->execute();
$fr="fr";
$addDescFR=$connection->prepare("INSERT INTO Description(ProductID, Language, Description) VALUES (?,?,?)");
$addDescFR->bind_param("sss",$lll['ls'], $fr, $_POST['DescriptionFR']);
$addDescFR->execute();
echo "success";
?>