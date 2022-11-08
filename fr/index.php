<?php
    include "./phpscripts/dbConnection.php";
    mysqli_select_db($connection, "eshopzab");
    require_once("banner.php");
    $_SESSION['SelectFrom']=12;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marché en ligne</title>
    <link rel="stylesheet" href="../css/index.css">
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
    <script>
        //Load products
        var loadingItems=false;
        var endOfPr=false;
        function loadItems(data){
            if(data.substring(data.length-3)!="end"){
                $(".main-content-div").append(data);
                checkInCart()
                loadingItems=false;
            }
            else{
                endOfPr=true;
                $(".main-content-div").append(data.substring(0, data.length-3));
                checkInCart()
                $(".load-indicator").css("display","none")
            }
        }
        function showLoading(){
            if(!endOfPr){
                $(".load-indicator").css("display","flex")
            }
        }
        window.onscroll = function(ev) {
            if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight-10) {
                if(!loadingItems&&!endOfPr){
                    loadingItems=true;
                    $.ajax({
                        url: "./phpscripts/loadProducts.php",
                        type: "POST",
                        dataType: "html",
                        beforeSend: showLoading,
                        success: loadItems
                    });
                }
                if(endOfPr){
                    $(".load-indicator").css("display","none")
                }
                
            }
        };
        //Add to cart
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
        function checkInCart(){
            var idList=[];
            $(".shopping-cart-item").each(function(index, element){
                idList.push(Number($(element).attr("id")));
            })
            for(let i=0;i<idList.length;i++){
                let el=$("#"+idList[i]+".cart-box");
                el.addClass("inCart");
                el.children(":first-child").css({"top":"80px"});
                el.children(":last-child").css({"top":"80px"});
                el.css({"background-color": "rgb(121, 255, 3)"});
            }
        }
        //AddToCart animation
        $(document).ready(function(){
            $(".main-content-div").on("click", ".cart-box", function(){
                if($(this).hasClass("inCart")){
                    $(this).children(":first-child").animate({
                        top: "0px"
                    }, 300);
                    $(this).children(":last-child").animate({
                        top: "0px"
                    }, 300);
                    $(this).animate({
                        backgroundColor: "rgb(250, 215, 20)"
                    }, 300);
                    $(this).removeClass("inCart")
                    var prID=$(this).attr("id");
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
                        top: "80px"
                    }, 300);
                    $(this).children(":last-child").animate({
                        top: "80px"
                    }, 300);
                    $(this).animate({
                        backgroundColor: "rgb(121, 255, 3)"
                    }, 300);
                    $(this).addClass("inCart");
                    var pID=$(this).attr("id");
                    $.ajax({
                        url: "./phpscripts/addToCart.php",
                        type: "POST",
                        data: ({ProductID: pID}),
                        dataType: "html",
                        success: addToCartSuccess
                    });
                }
            });
            checkInCart();
        })
        
    </script>
</body>
</html>