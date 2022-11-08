<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../css/banner.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@500&family=Rubik&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <?php
    include "./phpscripts/dbConnection.php";
    mysqli_select_db($connection, "eshopzab");
    ini_set('session.save_path', '../session/');
    session_start();
    $_SESSION['lang']="en";
    ?>
    <script>
    var totalPrice=0;
    var allPrice=0;
    function loginValidateEmailUsername(text){
        var patternEmail  = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var patternUsername  = /^[a-zA-Z0-9]+$/;
        if((patternEmail.test(text)||patternUsername.test(text))&&text.length>4){
            return true;
        }
        else{
            return false;
        }
    }
    function validateEmail(email) {
        var pattern  = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(email);
    }
    function validateNamePattern(name) {
        var pattern  = /^[a-zA-Z]+$/;
        return pattern.test(name);
    }
    function validateNameLength(name){
        if(name.length<2){
            return false;
        }
        else{
            return true;
        }
    }
    function validateUsername(username) {
        var pattern  = /^[a-zA-Z0-9]+$/;
        return pattern.test(username);
    }
    function validateUsernameLength(username){
        if(username.length<5){
            return false;
        }
        else{
            return true;
        }
    }
    function validatePasswordNumber(password){
        var pattern = /\d/;
        return pattern.test(password);
    }
    function validatePasswordLength(password){
        if(password.length<8){
            return false;
        }
        else{
            return true;
        }
    }
    function validatePasswordSpecialCharacter(password){
        var pattern = /[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]+/;
        return pattern.test(password);
    }
    function afterGetData(data){
        if(data.substr(0, 7)=="success"){
            $(".later").attr("id","PPOpen")
            $("#PPOpen").html('<a class="text-btn-a" id="profileOpen">Hello, '+data.substr(8)+'</a><div class="login-profile-open-space"></div><div class="login-profile"><a href="profile.php" class="text-btn-a"><div class="login-profile-open"><img src="../pic/user.png" alt="" class="login-profile-list-img"><div class="login-profile-list-text">Open Profile</div></div></a><a href="./phpscripts/logout.php" class="text-btn-a"><div class="login-profile-logout"><img src="../pic/logout.png" alt="" class="login-profile-list-img"><div class="login-profile-list-text">Logout</div></div></a>')
            $(".price-container").append("<div class='cartt-box'><img src='../pic/cart.svg' alt='not-done' class='cartt-pic' title='picc'><img src='../pic/cart-done.svg' alt='done' class='cartt-done'></div>")
            $(".load-login-form").fadeOut();
            $(".login-form").removeClass("drop-show");
            if($(".users-reviews-container").length){
                $("<div class='add-review-container' style='display: none'><div class='add-review'>Add a review</div><div class='add-review-rating'><span class='star' id='star1'>★</span><span class='star' id='star2'>★</span><span class='star' id='star3'>★</span><span class='star' id='star4'>★</span><span class='star' id='star5'>★</span></div><textarea class='add-review-text'></textarea><div class='add-review-submit'>Submit</div></div>").insertBefore(".users-reviews-container")
                $(".add-review-container").slideDown(500);
            }
            var itemCard=$("div[class='item-card']");
            for(var k=0;k<itemCard.length;k++){
                var Cardid=itemCard.eq(k).attr("id");
                itemCard.eq(k).append("<div class='cart-box' id='"+Cardid+"'><img src='../pic/cart.svg' alt='not-done' class='cart-pic' title='Add to cart'><img src='../pic/cart-done.svg' alt='done' class='cart-done'></div>");
            }
            
        }
        if(data.substr(0, 9)=="WrongPass"){
            $(".login-login-label-password-error").html("Wrong password/login");
            $(".load-login-form").fadeOut();
        }
        
    }
    function loginFormLoading(){
        var hgt = $(".login-form").height()+"px";
        $(".load-login-form").css("height", hgt);
        $(".load-login-form").fadeIn();
        $(".load-login-form").css("display", "flex");
    }
    var emailFreeVariable=true;
    var usernameFreeVariable=true;
    function CheckIfEmailtaken(data){
        if(data=="taken"){
            $(".login-signup-label-email-error").html("Email is taken")
            emailFreeVariable=false;
        }
        if(data=="free"){
            $(".login-signup-label-email-error").empty();
            emailFreeVariable=true;
        }
    }
    function CheckIfUsernametaken(data){
        if(data=="taken"){
            $(".login-signup-label-username-error").html("Username is taken")
            usernameFreeVariable=false;
        }
        if(data=="free"){
            $(".login-signup-label-username-error").empty();
            usernameFreeVariable=true;
        }
    }
    function calculateTotal(data){
        if(data!=null&&data=="error"){
            return;
        }
        allPrice=0;
        var itemsInShopCart=$(".shopping-cart-items").find("div[class='shopping-cart-item-price']");
        for(let i=0;i<itemsInShopCart.length;i++){
            let multiplier=$(itemsInShopCart.eq(i)).closest(".shopping-cart-item").find(".shopping-cart-item-amount").val();
            multiplier=Number(multiplier);
            let a=itemsInShopCart.eq(i).html();
            a=Number(a.slice(0,-1));
            a=a*multiplier;
            allPrice+=a;
        }
        $("#priceSpan").html(allPrice);
    }
    function removeFromCartSuccess(data){
            if(data.substring(0,7)=="success"){
            var dataaArray=data.split("<next>");
            var proddID=dataaArray[1];
            $("#"+proddID+".shopping-cart-item").slideUp(300,"linear", function(){
                $("#"+proddID+".shopping-cart-item").remove();
                calculateTotal();
            });
            $("#"+proddID+".cart-box").removeClass("inCart");
            $("#"+proddID+".cart-box").children(":first-child").animate({top:"0px"}, 300);
            $("#"+proddID+".cart-box").children(":last-child").animate({top:"0px"}, 300);
            $("#"+proddID+".cart-box").animate({backgroundColor: "rgb(250, 215, 20)"}, 300);
        }
    }
    function submitOrderCheck(data){
        if(data.substring(0,7)=="success"){
            var dataaArray=data.split("<next>");
            var OrderID=dataaArray[1];
            var cartBoxes=$("div.cart-box");
            cartBoxes.removeClass("inCart");
            cartBoxes.children(":first-child").animate({top:"0px"},300);
            cartBoxes.children(":last-child").animate({top:"0px"},300);
            cartBoxes.animate({backgroundColor: "rgb(250, 215, 20)"},300);
            var carttBoxes=$("div.cartt-box");
            carttBoxes.removeClass("inCart");
            carttBoxes.children(":first-child").animate({marginTop:"17px"},300);
            carttBoxes.children(":last-child").animate({top:"0px"},300);
            carttBoxes.animate({backgroundColor: "rgb(250, 215, 20)"},300);
            $(".shop-msg").html("Your order was submitted. OrderID:"+OrderID);
            $(".shopping-cart-message").slideDown(300,"linear");
            setTimeout(function(){
                $(".shopping-cart-message").slideUp(300,"linear");
                $(".shop-msg").html("");
            }, 5000)
            $("#priceSpan").html("0");
            var shopItems=$("div[class='shopping-cart-item']");
            var shopItemsAmount=shopItems.length;
            console.log(shopItemsAmount)
            var j=0;
            var myinterval=setInterval(() => {
                if(j<shopItemsAmount){
                    shopItems.eq(j).slideUp(250);
                    j++;
                }
                else{
                    setTimeout(function(){
                        shopItems.remove();
                    },300)
                    clearInterval(myinterval);
                }
            }, 300);
        }
        else{
            $(".shop-msg").html("An Error occured");
            $(".shopping-cart-message").slideDown(300,"linear");
            setTimeout(function(){
                $(".shopping-cart-message").slideUp(300,"linear");
                $(".shop-msg").html("");
            }, 2500)
        }
    }
    function changeToEn(){
        var currentpath=window.location.href.split("/");
        var newpath=currentpath[0]+"/"+currentpath[1]+"/"+currentpath[2]+"/"+currentpath[3]+"/"+"en"+"/"+currentpath[5];
        window.location.href=newpath;
    }
    function changeToFr(){
        var currentpath=window.location.href.split("/");
        var newpath=currentpath[0]+"/"+currentpath[1]+"/"+currentpath[2]+"/"+currentpath[3]+"/"+"fr"+"/"+currentpath[5];
        window.location.href=newpath;
    }
    function changeToUa(){
        var currentpath=window.location.href.split("/");
        var newpath=currentpath[0]+"/"+currentpath[1]+"/"+currentpath[2]+"/"+currentpath[3]+"/"+"ua"+"/"+currentpath[5];
        window.location.href=newpath;
    }
    $(document).ready(function(){
        //Calculate total price
        $(".shopping-cart-items").on("change","input[class='shopping-cart-item-amount']", function(){
            var productIdToChange=$(this).closest(".shopping-cart-item").attr("id");
            var productAmountToChange=$(this).val();
            $.ajax({
                    url: "./phpscripts/changeItemValue.php",
                    type: "POST",
                    data: ({productIDchange: productIdToChange, productAmount: productAmountToChange}),
                    dataType: "html",
                    success: calculateTotal
                });
        })
        //Submit Order
        $(".shopping-cart-order").bind("click", function(){
            var rrrd=0;
            $.ajax({
                url: "./phpscripts/submitOrder.php",
                type: "POST",
                data: ({check:rrrd}),
                dataType: "html",
                success: submitOrderCheck
            });
        })
        //
        $(".login-login-input-password").bind("change", function(){
                $(".login-login-label-password-error").empty();
        })
        //ShoppingCartDrop
        $("#shoppingDrop").bind("click", function(){
            $(".login-form").removeClass("drop-show")
            $(".shopping-cart-list").toggleClass("drop-show")
            if($("#PPOpen").hasClass("dropped")){
                $("#PPOpen").removeClass("dropped")
                $(".login-profile").removeAttr("style")
                $("#profileOpen").removeAttr("style")
                $(".login-profile-open-space").removeAttr("style")
            }
        })
        //LoginFormDrop
        $("#loginDrop").bind("click", function(){
            $(".shopping-cart-list").removeClass("drop-show")
            $(".login-form").toggleClass("drop-show")
        })
        //LoginToSignUp Switch
        $(".login-login-text-signup").bind("click", function(){
            $(".login-form").css("height","750px")
            $(".login-login").animate({
                marginLeft: "-420px"
            }, 300)
            $(".login-signup").animate({
                marginLeft: "0px"
            }, 300)
        })
        //SignUpToLogin Switch
        $(".login-signup-text-login").bind("click", function(){
            $(".login-form").css("height","430px")
            $(".login-login").animate({
                marginLeft: "0px"
            }, 300)
            $(".login-signup").animate({
                marginLeft: "420px"
            }, 300)
        })
        //Validate SignUp Email
        $(".login-signup-input-email").bind("blur", function(){
            if(!validateEmail($(".login-signup-input-email").val())){
                $(".login-signup-label-email-error").html("Email doesn't match")
            }
            if(validateEmail($(".login-signup-input-email").val())){
                $(".login-signup-label-email-error").empty();
                var emailToCheck=$(".login-signup-input-email").val();
                $.ajax({
                    url: "./phpscripts/emailTakenCheck.php",
                    type: "POST",
                    data: ({email: emailToCheck}),
                    dataType: "html",
                    success: CheckIfEmailtaken
                });
            }
            if($(".login-signup-input-email").val()==""){
                $(".login-signup-label-email-error").empty();
            }
        })
        //Validate SignUp Name
        $(".login-signup-input-name").bind("blur", function(){
            if(!validateNameLength($(".login-signup-input-name").val())){
                $(".login-signup-label-name-error").html("Name too short")
            }
            if(!validateNamePattern($(".login-signup-input-name").val())){
                $(".login-signup-label-name-error").html("Name not valid")
            }
            if(validateNameLength($(".login-signup-input-name").val())&&validateNamePattern($(".login-signup-input-name").val())){
                $(".login-signup-label-name-error").empty();
            }
            
            if($(".login-signup-input-name").val()==""){
                $(".login-signup-label-name-error").empty();
            }
        })
        //Validate SignUp Username
        $(".login-signup-input-username").bind("blur", function(){
            if(!validateUsernameLength($(".login-signup-input-username").val())){
                $(".login-signup-label-username-error").html("Username is too short")
            }
            if(!validateUsername($(".login-signup-input-username").val())){
                $(".login-signup-label-username-error").html("Use only numbers and letters")
            }
            if(validateUsername($(".login-signup-input-username").val()) && validateUsernameLength($(".login-signup-input-username").val())){
                $(".login-signup-label-username-error").empty();
                var usernameToCheck=$(".login-signup-input-username").val();
                $.ajax({
                    url: "./phpscripts/usernameTakenCheck.php",
                    type: "POST",
                    data: ({username: usernameToCheck}),
                    dataType: "html",
                    success: CheckIfUsernametaken
                });
            }
            if($(".login-signup-input-username").val()==""){
                $(".login-signup-label-username-error").empty();
            }
        })
        //Validate SignUp Password
        $(".login-signup-input-password").bind("keyup", function(){
            if(!validatePasswordLength($(".login-signup-input-password").val())||$(".login-signup-input-password").val()==""){
                $(".password-todo-list-item-1").css("color", "black")
                $("#circle1").css("color","black")
                $("#tick1").css("opacity","0%")
            }
            if(validatePasswordLength($(".login-signup-input-password").val())){
                $(".password-todo-list-item-1").css("color", "#52FF00")
                $("#circle1").css("color","#52FF00")
                $("#tick1").css("opacity","100%")
            }
            if(!validatePasswordNumber($(".login-signup-input-password").val())||$(".login-signup-input-password").val()==""){
                $(".password-todo-list-item-2").css("color", "black")
                $("#circle2").css("color","black")
                $("#tick2").css("opacity","0%")
            }
            if(validatePasswordNumber($(".login-signup-input-password").val())){
                $(".password-todo-list-item-2").css("color", "#52FF00")
                $("#circle2").css("color","#52FF00")
                $("#tick2").css("opacity","100%")
            }
            if(!validatePasswordSpecialCharacter($(".login-signup-input-password").val())||$(".login-signup-input-password").val()==""){
                $(".password-todo-list-item-3").css("color", "black")
                $("#circle3").css("color","black")
                $("#tick3").css("opacity","0%")
            }
            if(validatePasswordSpecialCharacter($(".login-signup-input-password").val())){
                $(".password-todo-list-item-3").css("color", "#52FF00")
                $("#circle3").css("color","#52FF00")
                $("#tick3").css("opacity","100%")
            }
        })
        //Validate SignUp PasswordRepeat
        $(".login-signup-input-rep-password").bind("blur", function(){
            if($(".login-signup-input-rep-password").val()!=$(".login-signup-input-password").val()){
                $(".login-signup-label-rep-password-error").html("Passwords don't match")
            }
            if(($(".login-signup-input-rep-password").val()==$(".login-signup-input-password").val())||$(".login-signup-input-rep-password").val()==""||$(".login-signup-input-password").val()==""){
                $(".login-signup-label-rep-password-error").empty()
            }
        })
        //Registration
        $("#register").bind("click", function(){
            if(validatePasswordLength($(".login-signup-input-password").val()) && validatePasswordNumber($(".login-signup-input-password").val()) && validatePasswordSpecialCharacter($(".login-signup-input-password").val()) && $(".login-signup-input-password").val()!="" && validateUsername($(".login-signup-input-username").val()) && $(".login-signup-input-username").val()!="" && validateNamePattern($(".login-signup-input-name").val()) && $(".login-signup-input-name").val()!="" && validateEmail($(".login-signup-input-email").val()) && $(".login-signup-input-email").val()!="" && ($(".login-signup-input-rep-password").val()==$(".login-signup-input-password").val()) && emailFreeVariable && usernameFreeVariable){
                var Username=$(".login-signup-input-username").val();
                var Email=$(".login-signup-input-email").val();
                var Name=$(".login-signup-input-name").val();
                var Password=$(".login-signup-input-password").val();
                var RepeatPassword=$(".login-signup-input-rep-password").val();
                $.ajax({
                    url: "./phpscripts/registration.php",
                    type: "POST",
                    data: ({UserUsername: Username, UserEmail: Email, UserName: Name, UserPassword: Password, UserRepeatPassword: RepeatPassword}),
                    dataType: "html",
                    beforeSend: loginFormLoading,
                    success: afterGetData
                });
            }
        })
        //Validate SignUp Login/Email
        $(".login-login-input-email").bind("blur", function(){
            if(!loginValidateEmailUsername($(".login-login-input-email").val())){
                $(".login-login-label-email-error").html("Email/username doesn't match pattern");
            }
            if(loginValidateEmailUsername($(".login-login-input-email").val())||$(".login-login-input-email").val()==""){
                $(".login-login-label-email-error").empty();
            }
        })
        //Login
        $("#loginBTN").bind("click", function(){
            if(loginValidateEmailUsername($(".login-login-input-email").val())&&$(".login-login-input-email").val()!=""&&$(".login-login-input-password").val()!=""){
                var UnameEmail=$(".login-login-input-email").val();
                var pword=$(".login-login-input-password").val();
                $.ajax({
                    url: "./phpscripts/login.php",
                    type: "POST",
                    data: ({UsernameEmail: UnameEmail, Password: pword}),
                    dataType: "html",
                    beforeSend: loginFormLoading,
                    success: afterGetData
                });
            }
        })
        $(".shopping-cart-items").on("click","div[class='shopping-cart-item-delete']", function(){
                var prID=$(this).attr("id");
                $.ajax({
                url: "./phpscripts/removeFromCart.php",
                type: "POST",
                data: ({ProductID: prID}),
                dataType: "html",
                success: removeFromCartSuccess
            });
        })
        //Show login dropDown
        $(".buttons-right").on("click","#PPOpen", function(){
            if($(this).hasClass("dropped")){
                $(this).removeClass("dropped")
                $(".login-profile").removeAttr("style")
                $("#profileOpen").removeAttr("style")
                $(".login-profile-open-space").removeAttr("style")
            }
            else{
                if($(".shopping-cart-list").hasClass("drop-show")){
                    $(".shopping-cart-list").removeClass("drop-show");
                }
                $(this).addClass("dropped")
                $(".login-profile").css({"display": "block", "opacity": "100%", "pointer-events": "all", "transition": "opacity .3s linear"})
                $("#profileOpen").css({"color": "rgba(0, 0, 0, 0.662)", "transition":"all .2s linear"})
                $(".login-profile-open-space").css({"display": "block","opacity":"100%","pointer-events":"all"})
            }
        })
        //Burger animation
        $('#nav-icon3').click(function(){
            if($(this).hasClass("open")){
                $(this).removeClass("open")
                $("body, html").removeAttr("style");
                $(".header-container").animate({
                    marginLeft: "-100%"
                },500)
            }
            else{
                $(this).addClass("open")
                $("body, html").css({"margin": "0", "height": "100%", "overflow": "hidden"})
                $(".header-container").animate({
                    marginLeft: "0%"
                },500)
            }
	    });
    })
    </script>
</head>
<body>
<div class="header-box">
    <div class="nav-container">
        <div id="nav-icon3">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
        <div class="header-container">
            <div class="buttons-left">
                <div class="text-btn">
                    <div class="lang-order">
                        <img src="../pic/english-lang.png" class="lang-pic" alt="English" onclick="changeToEn()">
                        <img src="../pic/french-lang.png" class="lang-pic" alt="French" onclick="changeToFr()">
                        <img src="../pic/ukrainian-lang.png" class="lang-pic" alt="Ukrainian" onclick="changeToUa()">
                    </div>
                </div>
                <div class="text-btn"><a class="text-btn-a" onclick="window.location.href='contacts.php'">About</a></div>
            </div>
            <div class="logo-container" onclick="window.location.href='index.php'">
                <img src="../pic/logo-header.svg" alt="logo" class="logo-img">
            </div>
            <div class="buttons-right">
            <?php
            if(isset($_COOKIE['CookieUserName'])){
            ?>
                <div class="text-btn" id="CartOpen">
                    <a class="text-btn-a" id="shoppingDrop">Shopping Cart</a>
                    <div class="shopping-cart-list">
                        <div class="shopping-cart-title">Your shopping cart contents:</div>
                        <div class="shopping-cart-items">
                            <?php
                            $totalprice=0;
                            if($_SESSION['ShoppingCart']){
                            foreach($_SESSION['ShoppingCart'] as $key=>$value){
                                $qq=$connection->prepare("SELECT ProductID, ProductTitle, Price, Picture1 FROM Products JOIN Pictures USING(ProductID) WHERE ProductID=?");
                                $qq->bind_param("s", $key);
                                $qq->execute();
                                $qqq=$qq->get_result();
                                $qqqq=$qqq->fetch_assoc();
                                $totalprice=$totalprice+$qqqq['Price']*$value;

                                $cc=$connection->prepare("SELECT Description FROM Description WHERE ProductID=? AND Language=?");
                                $cc->bind_param("ss", $key, $_SESSION['lang']);
                                $cc->execute();
                                $ccc=$cc->get_result();
                                $description=$ccc->fetch_assoc();
                            ?>
                            <div class="shopping-cart-item" id="<?=$key?>">
                                <div class="shopping-cart-item-picture" style="background-image: url(../productpictures/<?=$qqqq['Picture1']?>)"></div>
                                <div class="shopping-cart-item-text">
                                    <div class="shopping-cart-item-title"><?=$qqqq['ProductTitle']?></div>
                                    <div class="shopping-cart-item-description"><?=$description['Description']?></div>
                                </div>
                                <input class="shopping-cart-item-amount" type="number" value="<?=$value?>" min="1" max="9">
                                <div class="shopping-cart-item-price"><?=$qqqq['Price']?>$</div>
                                <div class="shopping-cart-item-delete" id="<?=$key?>">
                                    <img class="shopping-cart-item-delete-cross" src="../pic/x-icon.svg"></img>
                                </div>
                            </div>
                            <?php
                            }
                        }
                            ?>
                        </div>
                        <div class="shopping-cart-footer">
                            <div class="shopping-cart-total">Total: <span id="priceSpan"><?=$totalprice?></span>$</div>
                            <div class="shopping-cart-order">Order</div>
                        </div>
                        <div class="shopping-cart-message">
                            <div class="shop-msg"></div>
                        </div>
                    </div>
                </div>
                    <?php
            }
                    if(isset($_COOKIE['CookieUserName'])){
                    ?>
                    <div class="text-btn" id="PPOpen">
                    <a class="text-btn-a" id="profileOpen">Hello, <?=$_COOKIE['CookieUserName']?></a>
                    <div class="login-profile-open-space"></div>
                    <div class="login-profile">
                        <a href="profile.php" class="text-btn-a">
                        <div class="login-profile-open">
                            <img src="../pic/user.png" alt="" class="login-profile-list-img">
                            <div class="login-profile-list-text">Open Profile</div>
                        </div>
                        </a>
                        <a href="./phpscripts/logout.php" class="text-btn-a">
                        <div class="login-profile-logout">
                            <img src="../pic/logout.png" alt="" class="login-profile-list-img">
                            <div class="login-profile-list-text">Logout</div>
                        </div>
                        </a>
                    </div>
                    </div>
                    <?php
                    }
                    else{
                    ?>
                    <div class="text-btn later" id="LoginOpen">
                    <a class="text-btn-a" id="loginDrop">Log in</a>
                    <div class="login-form">
                        <div class="login-login">
                            <div class="login-login-h">Log in</div>
                            <form action="" name="loginForm" id="loginForm" onsubmit="return false">
                                <div class="login-login-label-email">Email or username</div>
                                <div class="login-login-label-email-error"></div>
                                <input type="text" class="login-login-input-email" name="loginLogin">
                                <div class="login-login-label-password">Password</div>
                                <div class="login-login-label-password-error"></div>
                                <input type="password" class="login-login-input-password" name="loginPassword">
                                <input type="submit" value="Login" id="loginBTN" class="login-login-button-submit">
                                <div class="login-login-text-signup">Don’t have an account yet? Sign up</div>
                            </form>
                        </div>
                        <div class="login-signup">
                            <div class="login-signup-h">Sign up</div>
                            <form action="" name="signupForm" id="signupForm" onsubmit="return false">
                                <div class="login-signup-label-email">Email</div>
                                <div class="login-signup-label-email-error"></div>
                                <input type="email" class="login-signup-input-email" name="signupEmail">
                                <div class="login-signup-label-name">Name</div>
                                <div class="login-signup-label-name-error"></div>
                                <input type="text" class="login-signup-input-name" name="signupName">
                                <div class="login-signup-label-username">Username</div>
                                <div class="login-signup-label-username-error"></div>
                                <input type="text" class="login-signup-input-username" name="signupUsername">
                                <div class="login-signup-label-password">Password</div>
                                <input type="password" class="login-signup-input-password" name="signupPassword">
                                <div class="password-todo-list-container">
                                    <div class="password-todo-list-item-container">
                                        <div class="circle-todo-list" id="circle1">
                                            <img src="../pic/tickLogin.svg" alt="" class="tickLogin" id="tick1">
                                        </div>
                                        <div class="password-todo-list-item-1">At least 8 charachters in length</div>
                                    </div>
                                    <div class="password-todo-list-item-container">
                                        <div class="circle-todo-list" id="circle2">
                                            <img src="../pic/tickLogin.svg" alt="" class="tickLogin" id="tick2">
                                        </div>
                                        <div class="password-todo-list-item-2">One number</div>
                                    </div>
                                    <div class="password-todo-list-item-container">
                                        <div class="circle-todo-list" id="circle3">
                                            <img src="../pic/tickLogin.svg" alt="" class="tickLogin" id="tick3">
                                        </div>
                                        <div class="password-todo-list-item-3">One special symbol</div>
                                    </div>
                                </div>
                                <div class="login-signup-label-rep-password">Repeat password</div>
                                <div class="login-signup-label-rep-password-error"></div>
                                <input type="password" class="login-signup-input-rep-password" name="signupRepPassword">
                                <input type="submit" value="Sign up" id="register" class="login-signup-button-submit">
                                <div class="login-signup-text-login">Already have an account? Log in</div>
                            </form>
                        </div>
                        <div class="load-login-form">
                            <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                        </div>
                    </div>
                    </div>
                    <?php
                    }
                    ?>
            </div>
        </div>
    </div> 
</body>
</html>