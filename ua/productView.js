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