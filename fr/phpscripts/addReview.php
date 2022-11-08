<?php
ini_set('session.save_path', '../../session/');
session_start();
if(!isset($_COOKIE['CookieUserName'])||!isset($_POST['Text'])||!isset($_POST['RRating'])||!isset($_POST['ProductID'])){
    echo "error";
    die();
}
if(!is_numeric($_POST['RRating'])){
    echo "error";
    die();
}
include "dbConnection.php";
mysqli_select_db($connection, "eshopzab");
$checkIfProductExists=$connection->prepare("SELECT COUNT(*) AS cnt FROM Products WHERE ProductID=?");
$checkIfProductExists->bind_param("s",$_POST['ProductID']);
$checkIfProductExists->execute();
$aa=$checkIfProductExists->get_result();
$aaa=$aa->fetch_assoc();
if($aaa['cnt']==0){
    echo "error; product doesn't exist";
    die();
}
$date=date("Y-m-d");
$commentText=$_POST['Text'];
$commentText=htmlspecialchars($commentText, ENT_QUOTES);
$q=$connection->prepare("INSERT INTO Reviews(`ProductID`,`ReviewRating`,`ReviewAuthorName`,`ReviewDate`,`ReviewText`) VALUES(?,?,?,?,?)");
$q->bind_param("sssss", $_POST['ProductID'], $_POST['RRating'], $_SESSION['UserUsername'], $date, $commentText);
$q->execute();
echo "success<next>".$_POST['RRating']."<next>".$_SESSION['UserUsername']."<next>".$date."<next>".$commentText;
?>