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
        $("#generalmsg").html("Success!");
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
        $("#profileOpen").html("Hello, "+newName);
    }
    if(data=="ErrorUpdate"){
        $("#generalmsg").html("Error :(");
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
        $("#passwordmsg").html("Success!");
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
        $("#passwordmsg").html("Error :(");
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