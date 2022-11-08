<?php
include "dbConnection.php";
ini_set('session.save_path', '../../session/');
session_start();
mysqli_select_db($connection, "eshopzab");
if(!isset($_COOKIE['CookieUserName'])||$_FILES['file1']['name'] == ''){
    echo "error";
    die();
}
$fileAmount=count($_FILES);
$prID=$_SESSION['AddProductID'];
if($fileAmount==1){
    $test1 = explode('.', $_FILES['file1']['name']);
    $extension1 = end($test1);
    $pic1name=$prID."-1.".$extension1;
    $addPics=$connection->prepare("INSERT INTO Pictures(ProductID, Picture1) VALUES (?,?)");
    $addPics->bind_param("ss", $prID, $pic1name);
    $path="../../productpictures/";
    $location1 = $path.$pic1name;
    move_uploaded_file($_FILES['file1']['tmp_name'], $location1);
}
if($fileAmount==2){
    $test1 = explode('.', $_FILES['file1']['name']);
    $extension1 = end($test1);
    $pic1name=$prID."-1.".$extension1;
    $test2 = explode('.', $_FILES['file2']['name']);
    $extension2 = end($test2);
    $pic2name=$prID."-2.".$extension2;
    $addPics=$connection->prepare("INSERT INTO Pictures(ProductID, Picture1, Picture2) VALUES (?,?,?)");
    $addPics->bind_param("sss", $prID, $pic1name, $pic2name);
    $path="../../productpictures/";
    $location1 = $path.$pic1name;
    move_uploaded_file($_FILES['file1']['tmp_name'], $location1);
    $location2 = $path.$pic2name;
    move_uploaded_file($_FILES['file2']['tmp_name'], $location2);

}
if($fileAmount==3){
    $test1 = explode('.', $_FILES['file1']['name']);
    $extension1 = end($test1);
    $pic1name=$prID."-1.".$extension1;

    $test2 = explode('.', $_FILES['file2']['name']);
    $extension2 = end($test2);
    $pic2name=$prID."-2.".$extension2;

    $test3 = explode('.', $_FILES['file3']['name']);
    $extension3 = end($test3);
    $pic3name=$prID."-3.".$extension3;

    $addPics=$connection->prepare("INSERT INTO Pictures(ProductID, Picture1, Picture2, Picture3) VALUES (?,?,?,?)");
    $addPics->bind_param("ssss", $prID, $pic1name, $pic2name, $pic3name);
    $path="../../productpictures/";
    $location1 = $path.$pic1name;
    move_uploaded_file($_FILES['file1']['tmp_name'], $location1);
    $location2 = $path.$pic2name;
    move_uploaded_file($_FILES['file2']['tmp_name'], $location2);
    $location3 = $path.$pic3name;
    move_uploaded_file($_FILES['file3']['tmp_name'], $location3);
}
if($fileAmount==4){
    $test1 = explode('.', $_FILES['file1']['name']);
    $extension1 = end($test1);
    $pic1name=$prID."-1.".$extension1;

    $test2 = explode('.', $_FILES['file2']['name']);
    $extension2 = end($test2);
    $pic2name=$prID."-2.".$extension2;

    $test3 = explode('.', $_FILES['file3']['name']);
    $extension3 = end($test3);
    $pic3name=$prID."-3.".$extension3;

    $test4 = explode('.', $_FILES['file4']['name']);
    $extension4 = end($test4);
    $pic4name=$prID."-4.".$extension4;

    $addPics=$connection->prepare("INSERT INTO Pictures(ProductID, Picture1, Picture2, Picture3, Picture4) VALUES (?,?,?,?,?)");
    $addPics->bind_param("sssss", $prID, $pic1name, $pic2name, $pic3name, $pic4name);
    $path="../../productpictures/";
    $location1 = $path.$pic1name;
    move_uploaded_file($_FILES['file1']['tmp_name'], $location1);
    $location2 = $path.$pic2name;
    move_uploaded_file($_FILES['file2']['tmp_name'], $location2);
    $location3 = $path.$pic3name;
    move_uploaded_file($_FILES['file3']['tmp_name'], $location3);
    $location4 = $path.$pic4name;
    move_uploaded_file($_FILES['file4']['tmp_name'], $location4);
}
if($fileAmount==5){
    $test1 = explode('.', $_FILES['file1']['name']);
    $extension1 = end($test1);
    $pic1name=$prID."-1.".$extension1;

    $test2 = explode('.', $_FILES['file2']['name']);
    $extension2 = end($test2);
    $pic2name=$prID."-2.".$extension2;

    $test3 = explode('.', $_FILES['file3']['name']);
    $extension3 = end($test3);
    $pic3name=$prID."-3.".$extension3;

    $test4 = explode('.', $_FILES['file4']['name']);
    $extension4 = end($test4);
    $pic4name=$prID."-4.".$extension4;

    $test5 = explode('.', $_FILES['file5']['name']);
    $extension5 = end($test5);
    $pic5name=$prID."-5.".$extension5;

    $addPics=$connection->prepare("INSERT INTO Pictures(ProductID, Picture1, Picture2, Picture3, Picture4, Picture5) VALUES (?,?,?,?,?,?)");
    $addPics->bind_param("ssssss", $prID, $pic1name, $pic2name, $pic3name, $pic4name, $pic5name);
    $path="../../productpictures/";
    $location1 = $path.$pic1name;
    move_uploaded_file($_FILES['file1']['tmp_name'], $location1);
    $location2 = $path.$pic2name;
    move_uploaded_file($_FILES['file2']['tmp_name'], $location2);
    $location3 = $path.$pic3name;
    move_uploaded_file($_FILES['file3']['tmp_name'], $location3);
    $location4 = $path.$pic4name;
    move_uploaded_file($_FILES['file4']['tmp_name'], $location4);
    $location5 = $path.$pic5name;
    move_uploaded_file($_FILES['file5']['tmp_name'], $location5);
}
$addPics->execute();
unset($_SESSION['AddProductID']);
echo "success";
?>