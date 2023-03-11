<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/style.css">
    <?php include '../../Assets/links.php'; ?>
    <title>Document</title>
</head>
<body>
    
    <?php

        if(!isset($_SESSION["logged_in"])){
            header("../../Login");
            die();
        }

        $settings_username = $_GET["username"];

        require '../../Assets/connection.php';

        $get_user_info_sql = "SELECT * FROM users WHERE Username = '$settings_username'";
        $user_data = $mysql->query($get_user_info_sql);

        $user_data = $user_data->fetch_assoc();
    ?>
    <!-- Edit Settings -->
    <div class="settings-container">
        <form action="../../Server/update_settings.php" method="post" class="settings-form" enctype="multipart/form-data" >
            <h1>Edit Profile</h1>

            <?php if(isset($_SESSION["logged_in"])): ?>
                <div class="error"><?php echo $_SESSION["error-update-settings"]; ?></div>
            <?php endif; ?>

            <div class="input-fields">
                <input type="text" placholder="First Name" name="firstname" value="<?php echo $user_data["First_Name"]; ?>">
                <input type="text" placeholder="Last Name" name="lastname" value="<?php echo $user_data["Last_Name"]; ?>">
                <input type="text" placeholder="Username" name="username" value="<?php echo $user_data["Username"]; ?>">
                <input type="text" placeholder="Email" name="email" value="<?php echo $user_data["Email"]; ?>">
            </div>

            <?php if($user_data["Cover_Photo"] != "Not Selected"): ?>
                <img id="photo" src="../../Covers/<?php echo $user_data["Cover_Photo"]; ?>">
                <input type="file" class="cover-photo-input" name="coverphoto">
            <?php else: ?>
                <img id="photo">
                <input type="file" class="cover-photo-input" name="coverphoto">
            <?php endif; ?>

            <button type="submit">Submit</button>
        </form>
    </div>

    <script src="../../JavaScript/upload-cover-photo.js"></script>
</body>
</html>