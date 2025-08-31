<?php
// contact.php
// Có thể include header/footer nếu bạn có sẵn
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Liên hệ</title>
    <link rel="stylesheet" href="css/floating_contact.css" />
    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer"
    />
</head>
<body>
    <!-- Nút liên hệ -->
    <button id="contact-button"><i class="fas fa-phone"></i></button>

    <!-- Popup liên hệ -->
    <div id="contact-popup">
        <a href="https://zalo.me" class="contact-option zalo">
            <img
                width="16"
                height="16"
                src="img/zalo.png"
                alt="zalo"
            />
            <span>Chat trên Zalo</span>
        </a>
        <a href="https://www.facebook.com/profile.php?id=61579016938533" class="contact-option facebook">
            <i class="fab fa-facebook"></i>
            <span>Chat trên Facebook</span>
        </a>
        <a href="tel:0123456789" class="contact-option phone">
            <i class="fas fa-phone"></i>
            <span>Hotline: 0123456780</span>
        </a>
    </div>

    <script src="js/contact.js"></script>
</body>
</html>
