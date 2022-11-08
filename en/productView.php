<?php
    if(!isset($_GET['productID'])||!is_numeric($_GET['productID'])){
        header('Location: ./index.php');
        die();
    }
    require_once("banner.php");
    include "./phpscripts/dbConnection.php";
    mysqli_select_db($connection, "eshopzab");
    $productID=$_GET['productID'];
    $checkIfProductExists=$connection->prepare("SELECT COUNT(*) AS cnt FROM Products WHERE ProductID=?");
    $checkIfProductExists->bind_param("s",$productID);
    $checkIfProductExists->execute();
    $aa=$checkIfProductExists->get_result();
    $aaa=$aa->fetch_assoc();
    if($aaa['cnt']==0){
        header('Location: ./index.php');
        die();
    }
    $getProductData=$connection->prepare("SELECT ProductTitle, Price, OldPrice, IsOnDiscount, Description FROM Products JOIN Description USING(ProductID) WHERE Language = ? AND ProductID = ?");
    $getProductData->bind_param("ss",$_SESSION['lang'], $productID);
    $getProductData->execute();
    $pd=$getProductData->get_result();
    $ProductData=$pd->fetch_assoc();
    $getPictures=$connection->prepare("SELECT Picture1, Picture2, Picture3, Picture4, Picture5 FROM Pictures WHERE ProductID=?");
    $getPictures->bind_param("s",$productID);
    $getPictures->execute();
    $pp=$getPictures->get_result();
    $pictures=$pp->fetch_assoc();
    $countComments=$connection->prepare("SELECT COUNT(*) AS cnt FROM Reviews WHERE ProductID=?");
    $countComments->bind_param("s",$productID);
    $countComments->execute();
    $cc=$countComments->get_result();
    $ccomments=$cc->fetch_assoc();
    $commentsCount=$ccomments['cnt'];

    $avgRating=$connection->prepare("SELECT ROUND(AVG(ReviewRating),1) AS rat FROM Reviews WHERE ProductID=?");
    $avgRating->bind_param("s",$productID);
    $avgRating->execute();
    $rr=$avgRating->get_result();
    $ratingAVG=$rr->fetch_assoc();
    $AVG=$ratingAVG['rat'];

    $getComments=$connection->prepare("SELECT ReviewAuthorName, ReviewRating, ReviewText, ReviewDate FROM Reviews WHERE ProductID=? ORDER BY ReviewID DESC");
    $getComments->bind_param("s",$productID);
    $getComments->execute();
    $gg=$getComments->get_result();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View product</title>
    <link rel="stylesheet" href="../css/viewproduct.css">
    <link rel="stylesheet" href="../mainjs/slick-theme.css">
    <script src="../mainjs/slick.min.js"></script>
    <script src="./productView.js"></script>
</head>
<body>
    <div class="ProductMain">
        <div class="product-container" id="<?=$productID?>">
            <div class="product-title-container">
                <div class="product-title"><?=$ProductData['ProductTitle']?></div>
                <div class="reviews-container">
                    <div class="reviews-stars" style="background: -webkit-linear-gradient(left, rgba(255,184,0,1) 0%, rgba(255,184,0,1) <?=$AVG/5*100?>%, rgba(255,255,255,1) <?=$AVG/5*100?>%, rgba(255,255,255,1) 100%);">★★★★★</div>
                    <div class="reviews-text"><span id="asd"><?=$commentsCount?></span> Reviews</div>
                </div>
            </div>
            <div class="product-main-container">
                <div class="picture-container">
                    <div class="picture-switch-pics">
                        <img src="../productpictures/<?=$pictures['Picture1']?>" alt="" class="product-picture">
                        <?php
                        if($pictures['Picture2']!=""){
                        ?>
                        <img src="../productpictures/<?=$pictures['Picture2']?>" alt="" class="product-picture">
                        <?php
                        }
                        if($pictures['Picture3']!=""){
                        ?>
                        <img src="../productpictures/<?=$pictures['Picture3']?>" alt="" class="product-picture">
                        <?php
                        }
                        if($pictures['Picture4']!=""){
                        ?>
                        <img src="../productpictures/<?=$pictures['Picture4']?>" alt="" class="product-picture">
                        <?php
                        }
                        if($pictures['Picture5']!=""){
                        ?>
                        <img src="../productpictures/<?=$pictures['Picture5']?>" alt="" class="product-picture">
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="main-info-container">
                    <div class="price-container">
                        <div class="price-c">
                            <div class="price"><?=$ProductData['Price']?>$</div>
                            <?php
                            if($ProductData['IsOnDiscount']==1){
                            ?>
                            <div class="old-price"><?=$ProductData['OldPrice']?>$</div>
                            <?php
                            }
                            ?>
                        </div>
                        <?php
                        if(isset($_COOKIE['CookieUserName'])){
                        ?>
                        <div class="cartt-box">
                            <img src="../pic/cart.svg" alt="not-done" class="cartt-pic" title="picc">
                            <img src="../pic/cart-done.svg" alt="done" class="cartt-done">
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="description-container"><?=$ProductData['Description']?></div>
                </div>
            </div>
            <?php
            if(isset($_COOKIE['CookieUserName'])){
            ?>
            <div class="add-review-container">
                <div class="add-review">Add a review</div>
                <div class="add-review-rating">
                    <span class="star" id="star1">★</span>
                    <span class="star" id="star2">★</span>
                    <span class="star" id="star3">★</span>
                    <span class="star" id="star4">★</span>
                    <span class="star" id="star5">★</span>
                </div>
                <textarea class="add-review-text"></textarea>
                <div class="add-review-submit">Submit</div>
            </div>
            <?php
            }
            ?>
            <div class="users-reviews-container">
                <div class="reviews-title-container">
                    <div class="add-review">Reviews</div>
                    <div class="reviews-container">
                        <div class="reviews-stars" style="background: -webkit-linear-gradient(left, rgba(255,184,0,1) 0%, rgba(255,184,0,1) <?=$AVG/5*100?>%, rgba(255,255,255,1) <?=$AVG/5*100?>%, rgba(255,255,255,1) 100%);">★★★★★</div>
                        <div class="reviews-text"><span id="asd"><?=$commentsCount?></span> Reviews</div>
                    </div>
                </div>
                <div class="comments-area">
                    <?php
                    if($commentsCount>0){
                        while($comments=$gg->fetch_assoc()){
                    ?>
                    <div class="comment-container">
                        <div class="comment-up-container">
                            <div class="comment-author"><?=$comments['ReviewAuthorName']?></div>
                            <div class="comment-date"><?=$comments['ReviewDate']?></div>
                        </div>
                        <div class="comment-rating" style="background: -webkit-linear-gradient(left, rgba(255,184,0,1) 0%, rgba(255,184,0,1) <?=$comments['ReviewRating']/5*100?>%, rgba(255,255,255,1) <?=$comments['ReviewRating']/5*100?>%, rgba(255,255,255,1) 100%);">★★★★★</div>
                        <div class="comment-text"><?=$comments['ReviewText']?></div>
                    </div>
                    <?php
                        }
                    }
                    else{
                    ?>
                    <div class="comment-container" id="noComments">
                        <div class="comment-up-container">
                            <div class="comment-author">No comments</div>
                            <div class="comment-date"></div>
                        </div>
                        <div class="comment-rating"></div>
                        <div class="comment-text">No comments here yet...</div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>