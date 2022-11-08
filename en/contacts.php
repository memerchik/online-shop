<?php
    include "./phpscripts/dbConnection.php";
    mysqli_select_db($connection, "eshopzab");
    require_once("banner.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts</title>
    <link rel="stylesheet" href="../css/contacts.css">
</head>
<body>
    <div class="contact-main">
        <div class="block header">
            <div class="headerh1">Online Market</div>
            <div class="headertext">We have everything you need</div>
        </div>
        <div class="block-reviews">
            <div class="review" style="align-self:flex-start" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
                <div class="review-head-container">
                    <div class="review-head-name">Alex</div>
                    <div class="review-head-date">20.06.2022</div>
                </div>
                <div class="review-text">The best shop I have ever ordered from!</div>
            </div>
            <div class="review" style="align-self:center" data-aos="zoom-in-down" data-aos-delay="300" data-aos-duration="1000">
                <div class="review-head-container">
                    <div class="review-head-name">Yaroslav</div>
                    <div class="review-head-date">29.06.2022</div>
                </div>
                <div class="review-text">The shop is brilliant and the website is so cool!</div>
            </div>
            <div class="review" style="align-self:flex-end" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
                <div class="review-head-container">
                    <div class="review-head-name">Maria</div>
                    <div class="review-head-date">03.07.2022</div>
                </div>
                <div class="review-text">The delivery was super fast, I enjoyed it!</div>
            </div>
        </div>
        <div class="block contacts" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
            <div class="contacth1">Contacts</div>
            <div class="contacts-list">
                <div class="contact" data-aos="fade-right" data-aos-delay="300" data-aos-duration="800">Phone number: <span class="contact-data">+380957647714</span></div>
                <div class="contact" data-aos="fade-right" data-aos-delay="300" data-aos-duration="800">Address: <span class="contact-data">Square Jan Palach, 2312 Luxembourg</span></div>
            </div>
        </div>
    </div>
    
    <script>
        AOS.init();
    </script>
</body>
</html>