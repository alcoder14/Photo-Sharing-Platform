<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../Assets/links.php' ?>
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Document</title>
</head>
<body>
    <?php

         // Set Identifier to determine which icon in selected in navbar
         $_SESSION["navbar-identifier"] = "Profile";

        // Import Mobile Header
        if(isset($_SESSION["logged_in"])){
            require '../Navbars/Mobile/mobile-header-user.php'; 
        } else {
            header("location: ../Login");
        }
    ?>

    <?php
        // Import Desktop Navbar
        require '../Navbars/Desktop/visitor_vs_user.php';
    ?>

    <?php

    if(isset($_SESSION["ids"])){
        unset($_SESSION["ids"]);
    }
        // GET DATA FROM DATABASE

        require '../Assets/connection.php';

        $username = $_GET["user"];

        $_SESSION["page"] = "../Profile/?user=$username";


        $get_users_data = "SELECT * FROM users WHERE Username = '$username'";
        $db_response_get_users = $mysql->query($get_users_data);

        $user_data = $db_response_get_users->fetch_assoc();

        $get_photos_num = "SELECT COUNT(*) AS 'sum_photos' FROM photos WHERE Username = '$username'";
        $photos_num = $mysql->query($get_photos_num);
        $photos_num = $photos_num->fetch_assoc()["sum_photos"];

        if(!isset($photos_num)){
            $photos_num = 0;
        }

        $get_views_num = "SELECT SUM(Views) AS 'sum_views' FROM photos WHERE Username = '$username'";
        $views_num = $mysql->query($get_views_num);
        $views_num = $views_num->fetch_assoc()["sum_views"];

        if(!isset($views_num)){
            $views_num = 0;
        }

        $get_downloads_num = "SELECT SUM(Downloads) AS 'sum_downloads' FROM photos WHERE Username = '$username'";
        $downloads_num = $mysql->query($get_downloads_num);
        $downloads_num = $downloads_num->fetch_assoc()['sum_downloads'];

        if(!isset($downloads_num)){
            $downloads_num = 0;
        }


    ?>

    <?php if($user_data["Cover_Photo"] != "Not Selected"): ?>
    <section class="profile-data background-set" style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url(../Covers/<?php echo $user_data["Cover_Photo"]; ?>)"> 
    <?php else: ?>
    <section class="profile-data">
    <?php endif; ?>
        <h2 class="profile-username">@<?php echo $username; ?></h2>
        <div class="profile-stats">
            <div class="data-component">
                <h3 class="heading">Full Name</h3>
                <div class="text-line"></div>
                <h2 class="content"><?php echo $user_data["First_Name"] . " " . $user_data["Last_Name"]; ?></h2>
            </div>
            <div class="data-component">
                <h3 class="heading">Photos</h3>
                <div class="text-line"></div>
                <h2 class="content"><?php echo $photos_num; ?></h2>
            </div>
            <div class="data-component">
                <h3 class="heading">Total Views</h3>
                <div class="text-line"></div>
                <h2 class="content"><?php echo $views_num; ?></h2>
            </div>
            <div class="data-component">
                <h3 class="heading">Total Downloads</h3>
                <div class="text-line"></div>
                <h2 class="content"><?php echo $downloads_num; ?></h2>
            </div>
        </div>
        <div class="profile-options">
            <?php if($_SESSION["logged_in"] == $username): ?>
                <a href="../Profile/Settings/?username=<?php echo $username; ?>"><i class="fa-solid fa-pen-to-square icons"></i></a>
            <?php else: ?>

                <?php 
                    $check_following_status = "SELECT * FROM followers WHERE Followed = '$username'";
                    $result = $mysql->query($check_following_status);
                    
                    if(mysqli_num_rows($result) > 0):

                ?>
                    <a href="../Following/unfollow.php?followed=<?php echo $username; ?>&follower=<?php echo $_SESSION["logged_in"]; ?>"><i class="fa-solid fa-user-check"></i></a>
                <?php else: ?>

                <a href="../Following/?followed=<?php echo $username; ?>&follower=<?php echo $_SESSION["logged_in"]; ?>"><i class="fa-solid fa-user-plus"></i></a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
    </section>

    <?php 

        $get_photos = "SELECT * FROM photos WHERE Username = '$username'";

        $db_response_photos = $mysql->query($get_photos);
            
    ?>

    <?php
        if(mysqli_num_rows($db_response_photos) != 0):
    ?>
        <section class="feed">

        <?php
            $_SESSION["ids"] = array();
            while($row = $db_response_photos->fetch_assoc()):
                array_push($_SESSION["ids"], $row["Photo_ID"]);
        ?>
            <div class="post">
                <div class="upper-row">
                    <a href="../Profile/?user=<?php echo $row["Username"]; ?>" class="text"><h3>@<?php echo $row["Username"]; ?></h3></a>
                    <?php if($_SESSION["logged_in"] == $row["Username"]): ?>
                        <a href="../Server/delete_post.php?id=<?php echo $row["Photo_ID"]; ?>&image_name=<?php echo $row["Image_Name"]; ?>"><i class="fa-solid fa-trash"></i></a>
                    <?php endif; ?>
                </div>
                
                <div>
                    <a href="../PhotoView?id=<?php echo $row["Photo_ID"]; ?>">
                        <img src="../Posts/<?php echo $row['Image_Name']; ?>" alt="<?php echo $row['Image_Name']; ?>" class="photo">
                    </a>

                    <div class="lower-row">
                        <i class="fa-solid fa-eye text"></i>
                        <h3 class="text"><?php echo $row["Views"]?></h3>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </section>

        <?php else: ?>
            <div class="no-posts-container">
                <h2 class="no-posts-yet">No posts yet</h2>
            </div>
        <?php endif; ?>

    <?php include '../Modals/UploadPhotoModal/upload_photo_modal.php'; ?>

    <script src="../JavaScript/upload-file.js"></script>
</body>
</html>