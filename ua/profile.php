
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
    <?php
        if(!isset($_COOKIE['CookieUserName'])){
           header('Location: index.php');
        }
        require_once("banner.php");
    ?>
    <script src="./profile.js"></script>
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