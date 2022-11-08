<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Market</title>
    <link rel="stylesheet" href="../css/index.css">
    <?php
        include "./phpscripts/dbConnection.php";
        mysqli_select_db($connection, "eshopzab");
        require_once("banner.php");
        $_SESSION['SelectFrom']=12;
    ?>
    <script src="./index.js"></script>
</head>
<body>
    <section class="main">
        <div class="main-content-div">
            <?php
            $selectProducts=$connection->prepare("SELECT ProductID, ProductTitle, Price, OldPrice, IsOnDiscount, Picture1 FROM Products JOIN Pictures USING(ProductID) LIMIT 0,12");
            $selectProducts->execute();
            $product=$selectProducts->get_result();
            while($productRow=$product->fetch_assoc()){
                if($productRow['IsOnDiscount']==1){
            ?>
            <div class="item-card" id="<?=$productRow['ProductID']?>">
                <a href="productView.php?productID=<?=$productRow['ProductID']?>"><img src="../productpictures/<?=$productRow['Picture1']?>" alt="" class="card-picture"></a>
                <div class="card-old-price"><?=$productRow['OldPrice']?>$</div>
                <div class="card-price"><?=$productRow['Price']?>$</div>
                <div class="card-product-text"><?=$productRow['ProductTitle']?></div>
                <?php
                if(isset($_COOKIE['CookieUserName'])){
                ?>
                <div class="cart-box" id="<?=$productRow['ProductID']?>">
                    <img src="../pic/cart.svg" alt="not-done" class="cart-pic" title="Add to cart">
                    <img src="../pic/cart-done.svg" alt="done" class="cart-done">
                </div>
                <?php
                }
                ?>
            </div>
            <?php
                }
                else{
            ?>
            <div class="item-card" id="<?=$productRow['ProductID']?>">
                <a href="productView.php?productID=<?=$productRow['ProductID']?>"><img src="../productpictures/<?=$productRow['Picture1']?>" alt="" class="card-picture"></a>
                <div class="card-price"><?=$productRow['Price']?>$</div>
                <div class="card-product-text"><?=$productRow['ProductTitle']?></div>
                <?php
                if(isset($_COOKIE['CookieUserName'])){
                ?>
                <div class="cart-box" id="<?=$productRow['ProductID']?>">
                    <img src="../pic/cart.svg" alt="not-done" class="cart-pic" title="Add to cart">
                    <img src="../pic/cart-done.svg" alt="done" class="cart-done">
                </div>
                <?php
                }
                ?>
            </div>
            <?php
                }
            }
            ?>
        </div>
        <div class="load-indicator">
            <div class="loader-cont">
                <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
            </div>
        </div>
    </section>
</body>
</html>