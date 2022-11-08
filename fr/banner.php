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
        $_SESSION['lang']="fr";
    ?>
    <script src="./banner.js"></script>
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
                <div class="text-btn"><a class="text-btn-a" onclick="window.location.href='contacts.php'">Contacts</a></div>
            </div>
            <div class="logo-container" onclick="window.location.href='index.php'">
                <img src="../pic/logo-header.svg" alt="logo" class="logo-img">
            </div>
            <div class="buttons-right">
            <?php
            if(isset($_COOKIE['CookieUserName'])){
            ?>
                <div class="text-btn" id="CartOpen">
                    <a class="text-btn-a" id="shoppingDrop">Panier</a>
                    <div class="shopping-cart-list">
                        <div class="shopping-cart-title">Contenu de votre panier:</div>
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
                            <div class="shopping-cart-order">Ordre</div>
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
                    <a class="text-btn-a" id="profileOpen"><?=$_COOKIE['CookieUserName']?></a>
                    <div class="login-profile-open-space"></div>
                    <div class="login-profile">
                        <a href="profile.php" class="text-btn-a">
                        <div class="login-profile-open">
                            <img src="../pic/user.png" alt="" class="login-profile-list-img">
                            <div class="login-profile-list-text">Profil ouvert</div>
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
                    <a class="text-btn-a" id="loginDrop">Connecter</a>
                    <div class="login-form">
                        <div class="login-login">
                            <div class="login-login-h">Connecter</div>
                            <form action="" name="loginForm" id="loginForm" onsubmit="return false">
                                <div class="login-login-label-email">Email ou username.</div>
                                <div class="login-login-label-email-error"></div>
                                <input type="text" class="login-login-input-email" name="loginLogin">
                                <div class="login-login-label-password">Mot de passe</div>
                                <div class="login-login-label-password-error"></div>
                                <input type="password" class="login-login-input-password" name="loginPassword">
                                <input type="submit" value="Login" id="loginBTN" class="login-login-button-submit">
                                <div class="login-login-text-signup">Inscrivez-vous</div>
                            </form>
                        </div>
                        <div class="login-signup">
                            <div class="login-signup-h">Inscrivez-vousp</div>
                            <form action="" name="signupForm" id="signupForm" onsubmit="return false">
                                <div class="login-signup-label-email">Email</div>
                                <div class="login-signup-label-email-error"></div>
                                <input type="email" class="login-signup-input-email" name="signupEmail">
                                <div class="login-signup-label-name">Prénom</div>
                                <div class="login-signup-label-name-error"></div>
                                <input type="text" class="login-signup-input-name" name="signupName">
                                <div class="login-signup-label-username">Username</div>
                                <div class="login-signup-label-username-error"></div>
                                <input type="text" class="login-signup-input-username" name="signupUsername">
                                <div class="login-signup-label-password">Mot de passe</div>
                                <input type="password" class="login-signup-input-password" name="signupPassword">
                                <div class="password-todo-list-container">
                                    <div class="password-todo-list-item-container">
                                        <div class="circle-todo-list" id="circle1">
                                            <img src="../pic/tickLogin.svg" alt="" class="tickLogin" id="tick1">
                                        </div>
                                        <div class="password-todo-list-item-1">Au moins 8 caractères de longueur</div>
                                    </div>
                                    <div class="password-todo-list-item-container">
                                        <div class="circle-todo-list" id="circle2">
                                            <img src="../pic/tickLogin.svg" alt="" class="tickLogin" id="tick2">
                                        </div>
                                        <div class="password-todo-list-item-2">Un numéro</div>
                                    </div>
                                    <div class="password-todo-list-item-container">
                                        <div class="circle-todo-list" id="circle3">
                                            <img src="../pic/tickLogin.svg" alt="" class="tickLogin" id="tick3">
                                        </div>
                                        <div class="password-todo-list-item-3">Un symbole spécial</div>
                                    </div>
                                </div>
                                <div class="login-signup-label-rep-password">Répéter le mot de passe</div>
                                <div class="login-signup-label-rep-password-error"></div>
                                <input type="password" class="login-signup-input-rep-password" name="signupRepPassword">
                                <input type="submit" value="Sign up" id="register" class="login-signup-button-submit">
                                <div class="login-signup-text-login">Log in</div>
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