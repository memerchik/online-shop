<?php
    if(!isset($_COOKIE['CookieUserName'])){
        header('Location: index.php');
    }
    require_once("banner.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/profile.css">
    <title>Профіль</title>
    <script>
    var emailTaken=false;
    var oldPswCorrect=-1;
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
        function validatePasswordNumber(password){
            var pattern = /\d/;
            return pattern.test(password);
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
        function generalWait(){
            $("#generalLoadCover").css({"opacity":"100%", "pointer-events":"all"});
        }
        function generalAfterGetData(data){
            if(data=="SuccessUpdate"){
                $("#generalmsg").html("Успіх!");
                $("#generalmsg").css({"opacity":"100%","background":"#EBFCDE", "transform":"scale(1)"});
                setTimeout(() => {
                    $("#generalLoadCover").css({"opacity":"0%","pointer-events":"none"})
                    $("#generalmsg").css({"opacity":"0%","transform":"scale(0.8)"})
                }, 1500);
                var newName=$("#change-input-name").val();
                var newSurname=$("#change-input-surname").val();
                var newEmail=$("#change-input-email").val();
                var newBirthDate=$("#change-input-birth-date").val();
                $("#info-name").html(newName);
                $("#info-surname").html(newSurname);
                $("#info-email").html(newEmail);
                $("#info-birth-date").html(newBirthDate.replace(/-/g,"."));
                $(".user-name").html(newName+" "+newSurname);
                $("#profileOpen").html("Привіт, "+newName);
            }
            if(data=="ErrorUpdate"){
                $("#generalmsg").html("Помилка :(");
                $("#generalmsg").css({"opacity":"100%","background":"#FCE1DE", "transform":"scale(1)"});
                setTimeout(() => {
                    $("#generalLoadCover").css({"opacity":"0%","pointer-events":"none"})
                    $("#generalmsg").css({"opacity":"0%","transform":"scale(0.8)"})
                }, 1500);
            }
        }
        function generalEmailTakenCheck(data){
            if(data=="taken"){
                $("#change-input-email").css("border","1px red solid");
                emailTaken=true;
            }
            if(data=="free"){
                $("#change-input-email").css("border","1px black solid");
                emailTaken=false;
            }
        }
        function passwordOldCheck(data){
            if(data=="incorrect"){
                $("#change-input-old-password").css({"border":"1px red solid", "color":"black"});
                oldPswCorrect=0;
            }
            if(data=="correct"){
                $("#change-input-old-password").css({"border":"1px black solid", "color":"black"});
                oldPswCorrect=1;
            }
        }
        function passwordOldWait(){
            $("#change-input-old-password").css({"disabled":"disabled","border":"1px grey solid", "color":"grey"});
        }
        function passwordChangeWait(){
            $("#passwordLoadCover").css({"opacity":"100%", "pointer-events":"all"});
        }
        function passwordChangeAfter(data){
            if(data=="successChange"){
                $("#passwordmsg").html("Успіх!");
                $("#passwordmsg").css({"opacity":"100%","background":"#EBFCDE", "transform":"scale(1)"});
                setTimeout(() => {
                    $("#passwordLoadCover").css({"opacity":"0%","pointer-events":"none"})
                    $("#passwordmsg").css({"opacity":"0%","transform":"scale(0.8)"})
                }, 1500);
                $("#change-input-old-password").val("");
                $("#change-input-new-password").val("");
                $("#change-repeat-password").val("");
                $(".prof-password-todo-list-item-1").css("color", "black")
                $("#prof-circle1").css("color","black")
                $("#prof-tick1").css("opacity","0%")
                $(".prof-password-todo-list-item-2").css("color", "black")
                $("#prof-circle2").css("color","black")
                $("#prof-tick2").css("opacity","0%")
                $(".prof-password-todo-list-item-3").css("color", "black")
                $("#prof-circle3").css("color","black")
                $("#prof-tick3").css("opacity","0%")
            }
            if(data=="error"){
                $("#passwordmsg").html("Помилка :(");
                $("#passwordmsg").css({"opacity":"100%","background":"#FCE1DE", "transform":"scale(1)"});
                setTimeout(() => {
                    $("#passwordLoadCover").css({"opacity":"0%","pointer-events":"none"})
                    $("#passwordmsg").css({"opacity":"0%","transform":"scale(0.8)"})
                }, 1500);
            }
        }
        function imageChange(data){
            if(data.substring(0,10)=="successImg"){
                var filename="../userpictures/"+data.substring(10);
                $(".user-picture").attr("src", filename)
            }
        }
        function showProductLoad(){
            $(".add-product-loader").css({"opacity":"100%","pointer-events":"all"})
        }
        function removeProductLoad(data){
            if(data=="success"){
                $(".add-product-loader").css({"opacity":"0%","pointer-events":"none"});
                $("#admin-add-product").val("");
                $("#product-description-en").val("");
                $("#product-description-ua").val("");
                $("#product-description-fr").val("");
                $("#admin-add-price").val("");
                $("#admin-add-price-old").val("");
                $("#pic1").val("");
                $("#pic2").val("");
                $(".admin-picture-column").eq(1).css("display","none")
                $("#pic3").val("");
                $(".admin-picture-column").eq(2).css("display","none")
                $("#pic4").val("");
                $(".admin-picture-column").eq(3).css("display","none")
                $("#pic5").val("");
                $(".admin-picture-column").eq(4).css("display","none")
                $("#picBtn1, #picBtn2, #picBtn3, #picBtn4, #picBtn5").removeAttr('style')
            }
        }
        function addLoadPics(data){
            if(data.split("<next>")[0]=="success"){
                var file_data = $("#pic1").prop('files')[0];
                var form_data = new FormData();
                form_data.append('file1', file_data);
                if($("#pic2").val!=""){
                    file_data = $("#pic2").prop('files')[0];
                    form_data.append('file2', file_data);
                }
                if($("#pic3").val!=""){
                    file_data = $("#pic3").prop('files')[0];
                    form_data.append('file3', file_data);
                }
                if($("#pic4").val!=""){
                    file_data = $("#pic4").prop('files')[0];
                    form_data.append('file4', file_data);
                }
                if($("#pic5").val!=""){
                    file_data = $("#pic5").prop('files')[0];
                    form_data.append('file5', file_data);
                }
                $.ajax({
                    url: './phpscripts/addProductPics.php',
                    dataType: 'html',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                 
                    type: 'POST',
                    success: removeProductLoad
                });
            }
        }
        function ChangeOrderStatus(data){
            if(data.substring(0,7)=="success"){
                var OrderChangeArray=data.split("<next>");
                var OrderChangeID=OrderChangeArray[1];
                $(".orders-row#"+OrderChangeID).addClass("changeSucc");
                setTimeout(function(){
                    $(".orders-row#"+OrderChangeID).removeClass("changeSucc");
                }, 900)
            }
            if(data.substring(0,5)=="error"){
                var OrderChangeArray=data.split("<next>");
                var OrderChangeID=OrderChangeArray[1];
                $(".orders-row#"+OrderChangeID).addClass("changeError");
                setTimeout(function(){
                    $(".orders-row#"+OrderChangeID).removeClass("changeError");
                }, 900)
            }
        }
        function DeleteOrder(data){
            if(data.substring(0,7)=="success"){
                var OrderDeleteArray=data.split("<next>");
                var OrderDeleteID=OrderDeleteArray[1];
                $(".orders-row#"+OrderDeleteID).slideUp(300, "linear", function(){
                    $(".orders-row#"+OrderDeleteID).remove();
                })
            }
            if(data.substring(0,6)=="error1"){
                var OrderDeleteArray=data.split("<next>");
                var OrderDeleteID=OrderDeleteArray[1];
                $(".orders-row#"+OrderDeleteID).addClass("changeError");
                setTimeout(function(){
                    $(".orders-row#"+OrderDeleteID).removeClass("changeError");
                }, 900)
            }
        }
        $(document).ready(function(){
            //Switch between pages
            $("#selectUserInfo").bind("click", function(){
                $(".select-item").css("font-size","25px")
                $("#selectUserInfo").css("font-size","27px")
                $(".select-marker").css({"margin-left":"0px", "border-bottom":"3px solid #000AFF", "width":"160px"})
                $(".page").css({"opacity":"0%", "pointer-events":"none"})
                $("#UserInfo").css({"opacity":"100%", "pointer-events":"all"})
            })
            $("#selectOrders").bind("click", function(){
                $(".select-item").css("font-size","25px")
                $("#selectOrders").css("font-size","27px")
                $(".select-marker").css({"margin-left":"160px","border-bottom":"3px solid #ff9d00", "width":"160px"})
                $(".page").css({"opacity":"0%", "pointer-events":"none"})
                $("#Orders").css({"opacity":"100%", "pointer-events":"all"})
            })
            $("#selectChange").bind("click", function(){
                $(".select-item").css("font-size","25px")
                $("#selectChange").css({"font-size":"27px"})
                $(".select-marker").css({"margin-left":"320px", "border-bottom":"3px solid rgb(5, 255, 0)"})
                $(".page").css({"opacity":"0%", "pointer-events":"none"})
                $("#ChangeUserInfo").css({"opacity":"100%", "pointer-events":"all"})
            })
            $("#selectAdminAddProduct").bind("click", function(){
                $(".select-item").css("font-size","25px")
                $("#selectAdminAddProduct").css({"font-size":"27px"})
                $(".select-marker").css({"margin-left":"480px", "border-bottom":"3px solid rgb(255 0 0)"})
                $(".page").css({"opacity":"0%", "pointer-events":"none"})
                $("#AdminAddProduct").css({"opacity":"100%", "pointer-events":"all"})
            })
            $("#selectAdminViewOrders").bind("click", function(){
                $(".select-item").css("font-size","25px")
                $("#selectAdminViewOrders").css({"font-size":"27px"})
                $(".select-marker").css({"margin-left":"640px", "border-bottom":"3px solid rgb(255 0 0)"})
                $(".page").css({"opacity":"0%", "pointer-events":"none"})
                $("#AdminViewOrders").css({"opacity":"100%", "pointer-events":"all"})
            })
            $("#selectAdminManageUsers").bind("click", function(){
                $(".select-item").css("font-size","25px")
                $("#selectAdminManageUsers").css({"font-size":"27px"})
                $(".select-marker").css({"margin-left":"800px", "border-bottom":"3px solid rgb(255 0 0)"})
                $(".page").css({"opacity":"0%", "pointer-events":"none"})
                $("#AdminManageUsers").css({"opacity":"100%", "pointer-events":"all"})
            })
            //Admin picture submit
            $("#picBtn1").bind("click", function(){
                $("#pic1").trigger("click");
            })
            $("#pic1").change(function(){
                $("#picBtn1").css("background-color","green")
                $(".admin-picture-column").eq(1).css("display","block")
            })
            $("#picBtn2").bind("click", function(){
                $("#pic2").trigger("click");
            })
            $("#pic2").change(function(){
                $("#picBtn2").css("background-color","green")
                $(".admin-picture-column").eq(2).css("display","block")
            })
            $("#picBtn3").bind("click", function(){
                $("#pic3").trigger("click");
            })
            $("#pic3").change(function(){
                $("#picBtn3").css("background-color","green")
                $(".admin-picture-column").eq(3).css("display","block")
            })
            $("#picBtn4").bind("click", function(){
                $("#pic4").trigger("click");
            })
            $("#pic4").change(function(){
                $("#picBtn4").css("background-color","green")
                $(".admin-picture-column").eq(4).css("display","block")
            })
            $("#picBtn5").bind("click", function(){
                $("#pic5").trigger("click");
            })
            $("#pic5").change(function(){
                $("#picBtn5").css("background-color","green")
            })
            //Add product
            $(".add-product-btn").bind("click", function(){
                if($("#admin-add-product").val()!=""&&$("#product-description-en").val()!=""&&$("#product-description-ua").val()!=""&&$("#product-description-fr").val()!=""&&$("#admin-add-price").val()!=""&&$("#admin-add-price-old").val()!=""&&($("#isOnDiscount").val()=="1"||$("#isOnDiscount").val()=="0")&&$("#pic1").val()!=""&&!isNaN($("#admin-add-price").val())&&!isNaN($("#admin-add-price-old").val())){
                    var addTitle=$("#admin-add-product").val();
                    var addDescriptionEN=$("#product-description-en").val();
                    var addDescriptionUA=$("#product-description-ua").val();
                    var addDescriptionFR=$("#product-description-fr").val();
                    var addPrice=Number($("#admin-add-price").val());
                    var addPriceOld=Number($("#admin-add-price-old").val());
                    var addIsOnDiscount=Number($("#isOnDiscount").val());
                    $.ajax({
                        url: "./phpscripts/addProduct.php",
                        type: "POST",
                        dataType: "html",
                        data: ({Title: addTitle, DescriptionEN: addDescriptionEN, DescriptionUA: addDescriptionUA, DescriptionFR: addDescriptionFR, Price: addPrice, PriceOld: addPriceOld, IsOnDiscount: addIsOnDiscount}),
                        beforeSend: showProductLoad,
                        success: addLoadPics
                    });
                }
                else{
                    $(".add-product-btn").addClass("shake");
                    setTimeout(function(){
                        $(".add-product-btn").removeClass("shake");
                    }, 900)
                }
            })
            //Change order status
            $("select[name='orders-status-change']").change(function(){
                var orderId=$(this).closest('.orders-row').attr("id");
                var sttatus=$(this).val();
                $.ajax({
                    url: "./phpscripts/changeOrderStatus.php",
                    type: "POST",
                    dataType: "html",
                    data: ({ID: orderId, Status: sttatus}),
                    success: ChangeOrderStatus
                });
            })
            //Delete order
            $("button[class='delete-order']").bind("click", function(){
                var orderId=$(this).closest('.orders-row').attr("id");
                $.ajax({
                    url: "./phpscripts/deleteOrder.php",
                    type: "POST",
                    dataType: "html",
                    data: ({IDtoDelete: orderId}),
                    success: DeleteOrder
                });
            })
            //Check new password
            $("#change-input-new-password").bind("keyup", function(){
                if(!validatePasswordLength($("#change-input-new-password").val())||$("#change-input-new-password").val()==""){
                    $(".prof-password-todo-list-item-1").css("color", "black")
                    $("#prof-circle1").css("color","black")
                    $("#prof-tick1").css("opacity","0%")
                }
                if(validatePasswordLength($("#change-input-new-password").val())){
                    $(".prof-password-todo-list-item-1").css("color", "#52FF00")
                    $("#prof-circle1").css("color","#52FF00")
                    $("#prof-tick1").css("opacity","100%")
                }
                if(!validatePasswordNumber($("#change-input-new-password").val())||$("#change-input-new-password").val()==""){
                    $(".prof-password-todo-list-item-2").css("color", "black")
                    $("#prof-circle2").css("color","black")
                    $("#prof-tick2").css("opacity","0%")
                }
                if(validatePasswordNumber($("#change-input-new-password").val())){
                    $(".prof-password-todo-list-item-2").css("color", "#52FF00")
                    $("#prof-circle2").css("color","#52FF00")
                    $("#prof-tick2").css("opacity","100%")
                }
                if(!validatePasswordSpecialCharacter($("#change-input-new-password").val())||$("#change-input-new-password").val()==""){
                    $(".prof-password-todo-list-item-3").css("color", "black")
                    $("#prof-circle3").css("color","black")
                    $("#prof-tick3").css("opacity","0%")
                }
                if(validatePasswordSpecialCharacter($("#change-input-new-password").val())){
                    $(".prof-password-todo-list-item-3").css("color", "#52FF00")
                    $("#prof-circle3").css("color","#52FF00")
                    $("#prof-tick3").css("opacity","100%")
                }
            })
            //Check password repeat
            $("#change-repeat-password").bind("blur", function(){
                if($("#change-repeat-password").val()!=$("#change-input-new-password").val()){
                    $("#change-repeat-password").css("border","1px red solid")
                }
                if(($("#change-repeat-password").val()==$("#change-input-new-password").val())||$("#change-repeat-password").val()==""||$("#change-input-new-password").val()==""){
                    $("#change-repeat-password").css("border","1px black solid")
                }
            })
            //General

            //Check name pattern & length
            $("#change-input-name").bind("blur", function(){
                if(!validateNameLength($(this).val())||!validateNamePattern($(this).val())){
                    $(this).css("border","1px red solid");
                }
                if((validateNameLength($(this).val())&&validateNamePattern($(this).val()))){
                    $(this).css("border","1px black solid");
                }
            })
            //Check Surname pattern & length
            $("#change-input-surname").bind("blur", function(){
                if(!validateNameLength($(this).val())||!validateNamePattern($(this).val())){
                    $(this).css("border","1px red solid");
                }
                if((validateNameLength($(this).val())&&validateNamePattern($(this).val()))){
                    $(this).css("border","1px black solid");
                }
            })
            //Check date pattern
            $("#change-input-birth-date").bind("blur", function(){
                if($(this).attr("type")!="date"){
                    $(this).css("border","1px red solid");
                }
                if($(this).attr("type")=="date"){
                    $(this).css("border","1px black solid");
                }
            })
            //Check Email pattern
            $("#change-input-email").bind("blur", function(){
                if(!validateEmail($(this).val())){
                    $(this).css("border","1px red solid");
                }
                if(validateEmail($(this).val())){
                    $(this).css("border","1px black solid");
                    var EmailValue=$(this).val();
                    $.ajax({
                        url: "./phpscripts/emailTakenCheckChange.php",
                        type: "POST",
                        data: ({Email: EmailValue}),
                        dataType: "html",
                        success: generalEmailTakenCheck
                    })
                }
            })
            //Save General Info
            $("#saveGeneral").bind("click", function(){
                if(validateEmail($("#change-input-email").val())&&validateNameLength($("#change-input-name").val())&&validateNamePattern($("#change-input-name").val())&&validateNamePattern($("#change-input-surname").val())&&validateNameLength($("#change-input-surname").val())&&emailTaken==false){
                    var uName=$("#change-input-name").val();
                    var uSurname=$("#change-input-surname").val();
                    var uBirthDate=$("#change-input-birth-date").val();
                    var uEmail=$("#change-input-email").val();
                    $.ajax({
                        url: "./phpscripts/updateGeneral.php",
                        type: "POST",
                        data: ({UserName: uName, UserEmail: uEmail, UserSurname: uSurname, UserBirthDate: uBirthDate}),
                        dataType: "html",
                        beforeSend: generalWait,
                        success: generalAfterGetData
                    });
                }
                else{
                    $("#saveGeneral").addClass("shake");
                    setTimeout(function(){
                        $("#saveGeneral").removeClass("shake");
                    }, 900)
                }
            })
            //End General
            //Password Change
            //Old Password Validate
            $("#change-input-old-password").bind("blur", function(){
                var oldPswd=$(this).val();
                $.ajax({
                        url: "./phpscripts/oldPasswordCheck.php",
                        type: "POST",
                        data: ({Password: oldPswd}),
                        dataType: "html",
                        beforeSend: passwordOldWait,
                        success: passwordOldCheck
                });
            })
            //Password Change
            $("#savePassword").bind("click", function(){
                if(oldPswCorrect==1&&validatePasswordLength($("#change-input-new-password").val())&&$("#change-input-new-password").val()!=""&&validatePasswordNumber($("#change-input-new-password").val())&&validatePasswordSpecialCharacter($("#change-input-new-password").val())&&($("#change-repeat-password").val()==$("#change-input-new-password").val())&&$("#change-repeat-password").val()!=""&&$("#change-input-old-password").val()!=""){
                    var oldpswd=$("#change-input-old-password").val();
                    var newpswd=$("#change-input-new-password").val();
                    $.ajax({
                        url: "./phpscripts/ChangePassword.php",
                        type: "POST",
                        data: ({OldPassword: oldpswd, NewPassword: newpswd}),
                        dataType: "html",
                        beforeSend: passwordChangeWait,
                        success: passwordChangeAfter
                    });
                }
                else{
                    $("#savePassword").addClass("shake");
                    setTimeout(function(){
                        $("#savePassword").removeClass("shake");
                    }, 900)
                }
            })
            //User Picture Change
            $(".input-file").change(function(){
                var file_data = $(this).prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                $.ajax({
                    url: './phpscripts/changeprofilepic.php',
                    dataType: 'html',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                 
                    type: 'POST',
                    success: imageChange
                });
            })
        })
    </script>
</head>
<body>
    <div class="parallax-wrapper">
        <div class="parallax-group" id="group-1">
            <div class="parallax-layer base-layer">
            </div>
        </div>
        <div class="parallax-group" id="group-2">
            <div class="parallax-layer main-layer">
                <div class="profile-wrap">
                    <div class="user-card">
                        <div class="change-pic">
                            <img class="user-picture" src="<?='../userpictures/'.$_SESSION['UserAvatarName']?>">
                            <input type="file" class="input-file" accept="image/*" name="test123">
                            <div class="user-picture-cover">Змінити картинку</div>
                        </div>
                        <div class="user-username"><?=$_SESSION['UserUsername']?></div>
                        <div class="user-name"><?=$_SESSION['UserName']?> <?=$_SESSION['UserSurname']?></div>
                        <div class="user-status"><?=$_SESSION['UserPermissionName']?></div>
                    </div>
                    <div class="user-data-container">
                        <div class="page-selector">
                            <div class="select-marker"></div>
                            <div class="select-item" id="selectUserInfo">Інформація</div>
                            <div class="select-item" id="selectOrders">Замовлення</div>
                            <div class="select-item" id="selectChange">Редагувати</div>
                            <?php
                            if($_SESSION['UserStatus']>=1){
                            ?>
                            <div class="select-item" id="selectAdminAddProduct">Додати</div>
                            <?php
                            }
                            if($_SESSION['UserStatus']>=2){
                            ?>
                            <div class="select-item" id="selectAdminViewOrders">Архів</div>
                            <?php
                            }
                            ?>                                                       
                        </div>
                        <div class="page-container">
                            <div class="page" id="UserInfo">
                                <table>
                                    <tr class="table-row">
                                        <td class="table-head">Ім'я</td>
                                        <td class="table-data" id="info-name"><?=$_SESSION['UserName']?></td>
                                    </tr>
                                    <tr class="table-row">
                                        <td class="table-head">Прізвище</td>
                                        <?php
                                        if($_SESSION['UserSurname']!=""){
                                        ?>
                                        <td class="table-data" id="info-surname"><?=$_SESSION['UserSurname']?></td>
                                        <?php
                                        }
                                        else{
                                        ?>
                                            <td class="table-data" id="info-surname">&ltПрізвизще не встановлене&gt</td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <tr class="table-row">
                                        <td class="table-head">Дата реєстрації</td>
                                        <td class="table-data"><?=str_replace("-",".",$_SESSION['UserRegisterDate'])?></td>
                                    </tr>
                                    <tr class="table-row">
                                        <td class="table-head">Дата народження</td>
                                        <?php
                                        if($_SESSION['UserBirthDate']!=""){
                                        ?>
                                        <td class="table-data" id="info-birth-date"><?=str_replace("-",".",$_SESSION['UserBirthDate'])?></td>
                                        <?php
                                        }
                                        else{
                                        ?>
                                            <td class="table-data" id="info-birth-date">&ltНемає дати народження&gt</td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <tr class="table-row">
                                        <td class="table-head">Електронна адреса</td>
                                        <td class="table-data" id="info-email"><?=$_SESSION['UserEmail']?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="page" id="Orders">
                                <table class="orders-table">
                                    <tr>
                                        <td class="orders-table-id">ID</td>
                                        <td class="orders-table-date">Дата</td>
                                        <td class="orders-table-list">Список</td>
                                        <td class="orders-table-price">Загальна ціна</td>
                                        <td class="orders-table-delivery">Статус</td>
                                    </tr>
                                </table>
                                <div class="orders-list">
                                <?php
                                $ordersSelect=$connection->prepare("SELECT OrderID, OrderDate, OrderStatus FROM Orders WHERE UserID=?");
                                $ordersSelect->bind_param("s",$_SESSION['UserUserID']);
                                $ordersSelect->execute();
                                $jjdk=$ordersSelect->get_result();
                                while($Orders=$jjdk->fetch_assoc()){
                                ?>
                                    <div class="orders-row">
                                        <div class="orders-row-id">#<?=$Orders['OrderID']?></div>
                                        <div class="orders-row-date"><?=$Orders['OrderDate']?></div>
                                        <div class="orders-row-list">
                                        <?php
                                        $rowPrice=0;
                                        $selectOrderItems=$connection->prepare("SELECT ItemID, ItemQuantity, ProductID, ProductTitle, Price FROM OrdersItemsList RIGHT JOIN Products ON OrdersItemsList.ItemID=Products.ProductID WHERE OrderID=?");
                                        $selectOrderItems->bind_param("s",$Orders['OrderID']);
                                        $selectOrderItems->execute();
                                        $kkdd=$selectOrderItems->get_result();
                                        while($OrdersItems=$kkdd->fetch_assoc()){
                                            $rowPrice=$rowPrice+($OrdersItems['Price']*$OrdersItems['ItemQuantity']);
                                        ?>
                                            <div class="orders-row-list-item" onclick="window.location.href='productView.php?productID=<?=$OrdersItems['ItemID']?>'"><?=$OrdersItems['ProductTitle']?> x<?=$OrdersItems['ItemQuantity']?></div>
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <div class="orders-row-price"><?=$rowPrice?>$</div>
                                        <div class="orders-row-delivery"><?=$Orders['OrderStatus']?></div>
                                    </div>
                                <?php
                                }
                                ?>
                                </div>
                            </div>
                            <div class="page" id="ChangeUserInfo">
                                <div class="change-container" id="general">
                                    <div class="change-header">Загальна інформація</div>
                                    <div class="change-input-header">Ім'я</div>
                                    <input type="text" class="change-input" name="change-input-name" id="change-input-name" value="<?=$_SESSION['UserName']?>">
                                    <div class="change-input-header">Прізвище</div>
                                    <input type="text" class="change-input" name="change-input-surname" id="change-input-surname" value="<?=$_SESSION['UserSurname']?>">
                                    <div class="change-input-header">Дата народження</div>
                                    <input class="change-input" id="change-input-birth-date" type="date" min="1899-01-01" max="<?=date('Y-m-d')?>" value="<?=$_SESSION['UserBirthDate']?>">
                                    <div class="change-input-header">Електронна адреса</div>
                                    <input class="change-input" id="change-input-email" type="text" value="<?=$_SESSION['UserEmail']?>">
                                    <button class="change-save" id="saveGeneral">Зберігти</button>
                                    <div class="change-cover" id="generalLoadCover">
                                        <div class="load-cont" id="generalLoadCont">
                                            <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                        </div>
                                        <div class="change-message" id="generalmsg">Успіх!</div>
                                    </div>
                                </div>
                                <div class="change-container" id="password">
                                    <div class="change-header">Пароль</div>
                                    <div class="change-input-header">Старий пароль</div>
                                    <input type="password" class="change-input" name="change-input-old-password" id="change-input-old-password">
                                    <div class="change-input-header">Новий пароль</div>
                                    <input type="password" class="change-input" name="change-input-new-password" id="change-input-new-password">
                                    <div class="prof-password-todo-list-container">
                                        <div class="prof-password-todo-list-item-container">
                                            <div class="prof-circle-todo-list" id="prof-circle1">
                                                <img src="../pic/tickLogin.svg" alt="" class="prof-tickLogin" id="prof-tick1">
                                            </div>
                                            <div class="prof-password-todo-list-item-1">Як мінімум 8 символів</div>
                                        </div>
                                        <div class="prof-password-todo-list-item-container">
                                            <div class="prof-circle-todo-list" id="prof-circle2">
                                                <img src="../pic/tickLogin.svg" alt="" class="prof-tickLogin" id="prof-tick2">
                                            </div>
                                            <div class="prof-password-todo-list-item-2">Одна цифра</div>
                                        </div>
                                        <div class="prof-password-todo-list-item-container">
                                            <div class="prof-circle-todo-list" id="prof-circle3">
                                                <img src="../pic/tickLogin.svg" alt="" class="prof-tickLogin" id="prof-tick3">
                                            </div>
                                            <div class="prof-password-todo-list-item-3">Один спеціальний символ</div>
                                        </div>
                                    </div>
                                    <div class="change-input-header" id="change-repeat">Повторити пароль</div>
                                    <input class="change-input" type="password" id="change-repeat-password" name="change-repeat-password">
                                    <button class="change-save" id="savePassword">Зберігти</button>
                                    <div class="change-cover" id="passwordLoadCover">
                                        <div class="load-cont" id="passwordLoadCont">
                                            <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                        </div>
                                        <div class="change-message" id="passwordmsg">Успіх!</div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if($_SESSION['UserStatus']>=1){
                            ?>
                            <div class="page" id="AdminAddProduct">
                                <div class="add-product-container">
                                    <div class="change-header">Додати продукт</div>
                                    <div class="change-input-header">Назва</div>
                                    <input type="text" class="admin-input" name="admin-add-product" id="admin-add-product">
                                    <div class="change-input-header">Опис Англійською</div>
                                    <textarea class="product-description" name="product-description-en" id="product-description-en"></textarea>
                                    <div class="change-input-header">Опис Українською</div>
                                    <textarea class="product-description" name="product-description-ua" id="product-description-ua"></textarea>
                                    <div class="change-input-header">Опис Французькою</div>
                                    <textarea class="product-description" name="product-description-fr" id="product-description-fr"></textarea>
                                    <div class="admin-inputs-row">
                                        <div class="admin-inputs-column">
                                            <div class="change-input-header">Ціна</div>
                                            <input type="number" class="admin-input-price" name="admin-add-price" id="admin-add-price">
                                        </div>
                                        <div class="admin-inputs-column">
                                            <div class="change-input-header">Стара ціна</div>
                                            <input type="number" class="admin-input-price" name="admin-add-price-old" id="admin-add-price-old">
                                        </div>
                                        <div class="admin-inputs-column-2">
                                            <div class="change-input-header">Акція</div>
                                            <select name="isOnDiscount" id="isOnDiscount" class="discount-select">
                                                <option value="0">Ні</option>
                                                <option value="1">Так</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="admin-inputs-row">
                                        <div class="admin-picture-column">
                                            <div class="admin-picture-header">Картинка 1</div>
                                            <input type="file" class="admin-picture-input" accept="image/*" name="pic1" id="pic1">
                                            <button id="picBtn1">Оберіть файл</button>
                                        </div>
                                        <div class="admin-picture-column">
                                            <div class="admin-picture-header">Картинка 2</div>
                                            <input type="file" class="admin-picture-input" accept="image/*" name="pic2" id="pic2">
                                            <button id="picBtn2">Оберіть файл</button>
                                        </div>
                                        <div class="admin-picture-column">
                                            <div class="admin-picture-header">Картинка 3</div>
                                            <input type="file" class="admin-picture-input" accept="image/*" name="pic3" id="pic3">
                                            <button id="picBtn3">Оберіть файл</button>
                                        </div>
                                        <div class="admin-picture-column">
                                            <div class="admin-picture-header">Картинка 4</div>
                                            <input type="file" class="admin-picture-input" accept="image/*" name="pic4" id="pic4">
                                            <button id="picBtn4">Оберіть файл</button>
                                        </div>
                                        <div class="admin-picture-column">
                                            <div class="admin-picture-header">Картинка 5</div>
                                            <input type="file" class="admin-picture-input" accept="image/*" name="pic5" id="pic5">
                                            <button id="picBtn5">Оберіть файл</button>
                                        </div>
                                    </div>
                                    <div class="add-product-btn">Додати продукт</div>
                                </div>
                                <div class="add-product-loader">
                                    <div class="add-loader-cover">
                                        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                    </div>
                                    <div class="add-message"></div>
                                </div>
                            </div>
                            <?php
                            }
                            if($_SESSION['UserStatus']>=2){
                            ?>
                            <div class="page" id="AdminViewOrders">
                                <table class="orders-table">
                                    <tr>
                                        <td class="orders-table-id">ID</td>
                                        <td class="orders-table-date">Дата</td>
                                        <td class="orders-table-list">Список</td>
                                        <td class="orders-table-price">Ціна</td>
                                        <td class="orders-table-delivery">Статус</td>
                                    </tr>
                                </table>
                                <div class="orders-list">
                                <?php
                                $ordersSelect=$connection->prepare("SELECT OrderID, OrderDate, OrderStatus FROM Orders");
                                $ordersSelect->execute();
                                $jjdk=$ordersSelect->get_result();
                                while($Orders=$jjdk->fetch_assoc()){
                                ?>
                                    <div class="orders-row" id="<?=$Orders['OrderID']?>">
                                        <div class="orders-row-id">#<?=$Orders['OrderID']?></div>
                                        <div class="orders-row-date"><?=$Orders['OrderDate']?></div>
                                        <div class="orders-row-list">
                                        <?php
                                        $rowPrice=0;
                                        $selectOrderItems=$connection->prepare("SELECT ItemID, ItemQuantity, ProductID, ProductTitle, Price FROM OrdersItemsList RIGHT JOIN Products ON OrdersItemsList.ItemID=Products.ProductID WHERE OrderID=?");
                                        $selectOrderItems->bind_param("s",$Orders['OrderID']);
                                        $selectOrderItems->execute();
                                        $kkdd=$selectOrderItems->get_result();
                                        while($OrdersItems=$kkdd->fetch_assoc()){
                                            $rowPrice=$rowPrice+($OrdersItems['Price']*$OrdersItems['ItemQuantity']);
                                        ?>
                                            <div class="orders-row-list-item" onclick="window.location.href='productView.php?productID=<?=$OrdersItems['ItemID']?>'"><?=$OrdersItems['ProductTitle']?> x<?=$OrdersItems['ItemQuantity']?></div>
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <div class="orders-row-price"><?=$rowPrice?>$</div>
                                        <div class="orders-row-delivery">
                                        <button class="delete-order">Видалити</button>
                                        <select name="orders-status-change" id="orders-status-change">
                                            <option value="Submitted" <?php if($Orders['OrderStatus']=="Submitted"){ echo "selected";} ?>>Submitted</option>
                                            <option value="Confirmed" <?php if($Orders['OrderStatus']=="Confirmed"){ echo "selected";} ?>>Confirmed</option>
                                            <option value="In Delivery" <?php if($Orders['OrderStatus']=="In Delivery"){ echo "selected";} ?>>In Delivery</option>
                                            <option value="Delivered" <?php if($Orders['OrderStatus']=="Delivered"){ echo "selected";} ?>>Delivered</option>
                                        </select>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>