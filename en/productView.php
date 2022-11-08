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
    <script>
    function afterSubmitComment(data){
        if(data.substring(0,7)=="success"){
            var commentToAddArray=data.split("<next>");
            var newRating=commentToAddArray[1];
            console.log(newRating);
            var newAuthor=commentToAddArray[2];
            var newDate=commentToAddArray[3];
            var newText=commentToAddArray[4];
            $(".comments-area").prepend("<div class='comment-container' style='display:none' id='newCommentContainer"+newAuthor+"'></div>");
            $("#newCommentContainer"+newAuthor).prepend("<div class='comment-up-container'><div class='comment-author'>"+newAuthor+"</div><div class='comment-date'>"+newDate+"</div></div>");
            $("#newCommentContainer"+newAuthor).append("<div class='comment-rating' style='background: -webkit-linear-gradient(left, rgba(255,184,0,1) 0%, rgba(255,184,0,1) "+newRating/5*100+"%, rgba(255,255,255,1) "+newRating/5*100+"%, rgba(255,255,255,1) 100%);'>★★★★★</div><div class='comment-text'>"+newText+"</div>")
            $("#newCommentContainer"+newAuthor).slideDown(500, "linear");
            //remove no comments
            if($("#noComments").length){
                $("#noComments").remove();
            }
            $(".add-review-text").val("");
            var counttt=Number($("#asd").html());
            $("[id=asd]").html(counttt+1);
        }
    }
    function addToCartSuccess(data){
            if(data.substring(0,7)=="success"){
                var dataArray=data.split("<next>");
                var prodID=dataArray[1];
                var prodTitle=dataArray[2];
                var prodPrice=dataArray[3];
                var prodPic=dataArray[4];
                var prodDescription=dataArray[5];

                if($(".shopping-cart-items").has("#"+prodID+".shopping-cart-item").length){
                }
                else{
                    $(".shopping-cart-items").append("<div class='shopping-cart-item' id='"+prodID+"' style='display: none'><div class='shopping-cart-item-picture' style='background-image: url(../productpictures/"+prodPic+")'></div><div class='shopping-cart-item-text'><div class='shopping-cart-item-title'>"+prodTitle+"</div><div class='shopping-cart-item-description'>"+prodDescription+"</div></div><input class='shopping-cart-item-amount' type='number' value='1' min='1' max='9'><div class='shopping-cart-item-price'>"+prodPrice+"$</div><div class='shopping-cart-item-delete' id='"+prodID+"'><img class='shopping-cart-item-delete-cross' src='../pic/x-icon.svg'></img></div></div>");
                    $("#"+prodID+".shopping-cart-item").slideDown();
                }
                calculateTotal()
            }
        }
    var rating=5;
    $(document).ready(function(){
        $(".picture-switch-pics").slick({
            infinite: false,
            autoplay: true,
            autoplaySpeed: 3000
        });
        //Rating
        $(".product-container").on("click","#star1", function(){
            $(".add-review-rating").css("background","-webkit-linear-gradient(left, rgba(255,184,0,1) 0%, rgba(255,184,0,1) 20%, rgba(255,255,255,1) 20%, rgba(255,255,255,1) 100%)")
            rating=1;
        })
        $(".product-container").on("click","#star2", function(){
            $(".add-review-rating").css("background","-webkit-linear-gradient(left, rgba(255,184,0,1) 0%, rgba(255,184,0,1) 40%, rgba(255,255,255,1) 40%, rgba(255,255,255,1) 100%)")
            rating=2;
        })
        $(".product-container").on("click","#star3", function(){
            $(".add-review-rating").css("background","-webkit-linear-gradient(left, rgba(255,184,0,1) 0%, rgba(255,184,0,1) 60%, rgba(255,255,255,1) 60%, rgba(255,255,255,1) 100%)")
            rating=3;
        })
        $(".product-container").on("click","#star4", function(){
            $(".add-review-rating").css("background","-webkit-linear-gradient(left, rgba(255,184,0,1) 0%, rgba(255,184,0,1) 80%, rgba(255,255,255,1) 80%, rgba(255,255,255,1) 100%)")
            rating=4;
        })
        $(".product-container").on("click","#star5", function(){
            $(".add-review-rating").css("background","-webkit-linear-gradient(left, rgba(255,184,0,1) 0%, rgba(255,184,0,1) 100%, rgba(255,255,255,1) 100%, rgba(255,255,255,1) 100%)")
            rating=5;
        })
        //Submit review
        $(".product-container").on("click",".add-review-submit", function(){
            var commentText=$(".add-review-text").val();
            var product=$(".product-container").attr("id");
            $.ajax({
                url: "./phpscripts/addreview.php",
                type: "POST",
                data: ({Text: commentText, ProductID: product, RRating: rating}),
                dataType: "html",
                success: afterSubmitComment
            });
        })
        var idList=[];
            $(".shopping-cart-item").each(function(index, element){
                idList.push(Number($(element).attr("id")));
            })
            if(idList.includes(Number($(".product-container").attr("id")))){
                let el=$(".cartt-box");
                el.addClass("inCart");
                el.children(":first-child").css({"margin-top":"97px"});
                el.children(":last-child").css({"top":"80px"});
                el.css({"background-color": "rgb(121, 255, 3)"});
            }
            $(".cartt-box").bind("click", function(){
                if($(this).hasClass("inCart")){
                    $(this).children(":first-child").animate({
                        marginTop: "17px"
                    }, 300);
                    $(this).children(":last-child").animate({
                        top: "0px"
                    }, 300);
                    $(this).animate({
                        backgroundColor: "rgb(250, 215, 20)"
                    }, 300);
                    $(this).removeClass("inCart")
                    var prID=$(".product-container").attr("id");
                    $.ajax({
                        url: "./phpscripts/removeFromCart.php",
                        type: "POST",
                        data: ({ProductID: prID}),
                        dataType: "html",
                        success: removeFromCartSuccess
                    });
                }
                else{
                    $(this).children(":first-child").animate({
                        marginTop: "97px"
                    }, 300);
                    $(this).children(":last-child").animate({
                        top: "80px"
                    }, 300);
                    $(this).animate({
                        backgroundColor: "rgb(121, 255, 3)"
                    }, 300);
                    $(this).addClass("inCart");
                    var pID=$(".product-container").attr("id");
                    $.ajax({
                        url: "./phpscripts/addToCart.php",
                        type: "POST",
                        data: ({ProductID: pID}),
                        dataType: "html",
                        success: addToCartSuccess
                    });
                }
            });
        });
    </script>
</body>
</html>