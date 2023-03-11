<?php

    session_start();

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $email = $_POST["email"];


    $current_username = $_SESSION["logged_in"];
    

    if(!isset($firstname) || !isset($lastname) || !isset($username) || !isset($email)){
        $error = "Some fields are empty";
        $_SESSION["error-update-settings"] = $error;
        header("location: ../Profile/?user=" . $_SESSION["logged_in"]);
        die();
    }

    require '../Assets/connection.php';

    // Chenge User Settings

    $update_user_sql = "UPDATE users SET First_Name = '$firstname', Last_Name = '$lastname', Email = '$email', Username = '$username' WHERE Username = '$current_username' ";

    $mysql->query($update_user_sql);

    // Change Usernames On Posts

    $update_post_username = "UPDATE photos SET Username = '$username' WHERE Username = '$current_username'";

    $mysql->query($update_post_username);

    // Change Usernames On Comments

    $update_comment_username = "UPDATE comments SET User_commented = '$username' WHERE User_commented = '$current_username'";

    $mysql->query($update_comment_username);

    // Update Cover Photo


    if($_FILES["coverphoto"]["name"] != ""){
        
        $file_name = $_FILES["coverphoto"]["name"];
        $file_size = $_FILES["coverphoto"]["size"];
        $file_tmp = $_FILES["coverphoto"]["tmp_name"];
        $target_dir = "../Covers/${file_name}";

        $file_ext = explode(".", $file_name);
        $file_ext = strtolower(end($file_ext));

        $allowed_ext = array("png", "jpg", "jpeg", "gif", "svg");

        // Delete the old cover photo

        $current_cover = "SELECT Cover_Photo FROM users WHERE Username = '$current_username'";
        $current_cover = $mysql->query($current_cover)->fetch_assoc()["Cover_Photo"];
        
        $current_cover_path = "../Covers/$current_cover";
        unlink($current_cover_path);

        // Validate file extension and move file to directory

        if(in_array($file_ext, $allowed_ext)){
            move_uploaded_file($file_tmp, $target_dir);
        }

        $cover_photo_sql = "UPDATE users SET Cover_Photo = '$file_name' WHERE Username = '$username'";

        $mysql->query($cover_photo_sql);
        unset($_FILES["coverphoto"]);
    }

    $_SESSION["logged_in"] = $username;

    //echo $_SESSION["logged_in"];
    //$_SESSION["logged_in"] = "aljaz_14";

    $mysql->close();

    header("location: ../Profile/?user=" . $_SESSION["logged_in"]);

    // Brisanje starih slik iz direktorija
?>