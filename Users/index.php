<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../Assets/links.php'; ?>
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Document</title>
</head>
<body>
    <?php

        // Set Identifier to determine which icon in selected in navbar
        $_SESSION["navbar-identifier"] = "Users";

        // Import Mobile Header
        if(isset($_SESSION["logged_in"])){
            require '../Navbars/Mobile/mobile-header-user.php'; 
        } else {
            require '../Navbars/Mobile/mobile-header-visitor.php'; 
        }
    ?>
    <?php
        $user_page = true;
        include '../Navbars/Desktop/visitor_vs_user.php';
    ?>
    
    <form class="search-users">
        <?php if(isset($_SESSION["search-query"])): ?>
            <input type="text" placeholder="Search users..." id="search_input" value="<?php echo $_SESSION["search-query"]; ?>">
        <?php else: ?>
            <input type="text" placeholder="Search users..." id="search_input">
        <?php endif; ?>
    </form>

    <section class="users">
        
    </section>

    <?php 
        // Import Mobile Navbar - Choose Between USER and VISITOR variants 
        if(isset($_SESSION["logged_in"])){
            require '../Modals/UploadPhotoModal/upload_photo_modal.php';
        } 

        require '../Assets/footer.php';
    ?>

    <script src="../JavaScript/search-users.js"></script>
    <script src="../JavaScript/upload-file.js"></script>
</body>
</html>