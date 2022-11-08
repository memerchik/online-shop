<?php
sleep(1);
include "dbConnection.php";
ini_set('session.save_path', '../../session/');
session_start();
mysqli_select_db($connection, "eshopzab");
$countPr=$connection->prepare("SELECT COUNT(*) as cnt FROM Products JOIN Pictures USING(ProductID)");
$countPr->execute();
$ccc=$countPr->get_result();
$ccn=$ccc->fetch_assoc();
if($_SESSION['SelectFrom']>=$ccn['cnt']){
    echo "end";
    die();
}
$selectPr=$connection->prepare("SELECT ProductID, ProductTitle, Price, OldPrice, IsOnDiscount, Picture1 FROM Products JOIN Pictures USING(ProductID) LIMIT ?, 4");
$selectPr->bind_param("s",$_SESSION['SelectFrom']);
$selectPr->execute();
$ssw=$selectPr->get_result();
$_SESSION['SelectFrom']=$_SESSION['SelectFrom']+4;
$outputdata="";
if(isset($_COOKIE['CookieUserName'])){
    while($newPr=$ssw->fetch_assoc()){
        if($newPr['IsOnDiscount']==1){
            $temp="<div class='item-card' id='".$newPr['ProductID']."'><a href='productView.php?productID=".$newPr['ProductID']."'><img src='../productpictures/".$newPr['Picture1']."' alt='' class='card-picture'></a><div class='card-old-price'>".$newPr['OldPrice']."</div><div class='card-price'>".$newPr['Price']."$</div><div class='card-product-text'>".$newPr['ProductTitle']."</div><div class='cart-box' id='".$newPr['ProductID']."'><img src='../pic/cart.svg' alt='not-done' class='cart-pic' title='Add to cart'><img src='../pic/cart-done.svg' alt='done' class='cart-done'></div></div>";
            $outputdata=$outputdata.$temp;
        }
        else{
            $temp="<div class='item-card' id='".$newPr['ProductID']."'><a href='productView.php?productID=".$newPr['ProductID']."'><img src='../productpictures/".$newPr['Picture1']."' alt='' class='card-picture'></a><div class='card-price'>".$newPr['Price']."$</div><div class='card-product-text'>".$newPr['ProductTitle']."</div><div class='cart-box' id='".$newPr['ProductID']."'><img src='../pic/cart.svg' alt='not-done' class='cart-pic' title='Add to cart'><img src='../pic/cart-done.svg' alt='done' class='cart-done'></div></div>";
            $outputdata=$outputdata.$temp;
        }
        
    }
}
if(!isset($_COOKIE['CookieUserName'])){
    while($newPr=$ssw->fetch_assoc()){
        if($newPr['IsOnDiscount']==1){
            $temp="<div class='item-card' id='".$newPr['ProductID']."'><a href='productView.php?productID=".$newPr['ProductID']."'><img src='../productpictures/".$newPr['Picture1']."' alt='' class='card-picture'></a><div class='card-old-price'>".$newPr['OldPrice']."</div><div class='card-price'>".$newPr['Price']."$</div><div class='card-product-text'>".$newPr['ProductTitle']."</div></div>";
            $outputdata=$outputdata.$temp;
        }
        else{
            $temp="<div class='item-card' id='".$newPr['ProductID']."'><a href='productView.php?productID=".$newPr['ProductID']."'><img src='../productpictures/".$newPr['Picture1']."' alt='' class='card-picture'></a><div class='card-price'>".$newPr['Price']."$</div><div class='card-product-text'>".$newPr['ProductTitle']."</div></div>";
            $outputdata=$outputdata.$temp;
        }
    }
}
if($_SESSION['SelectFrom']>=$ccn['cnt']){
    echo $outputdata."end";
    die();
}
echo $outputdata;
?>