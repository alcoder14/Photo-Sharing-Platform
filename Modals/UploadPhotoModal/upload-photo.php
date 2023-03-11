<?php

    session_start();
    require '../../Assets/connection.php';

    $file_name = $_FILES["image"]["name"];

     // Change Filename

     /*
    $get_current_ID = "SELECT Image_Counter FROM image_id";
    $current_ID = $mysql->query($get_current_ID);
    $current_ID = $current_ID->fetch_assoc()["Image_Counter"];

    $current_ID++;

    $update_currentID = "UPDATE image_id SET Image_Counter = $current_ID";
    $mysql->query($update_currentID);
    */

    $file_size = $_FILES["image"]["size"];
    $file_tmp = $_FILES["image"]["tmp_name"];
    //$file_name = "Image" . $current_ID;
    $target_dir = "../../Posts/${file_name}";

    $file_ext = explode(".", $file_name);
    $file_ext = strtolower(end($file_ext));

    $allowed_ext = array("png", "jpg", "jpeg", "gif", "svg");


    // Validate file extension and move file to directory

    if(in_array($file_ext, $allowed_ext)){
        move_uploaded_file($file_tmp, $target_dir);
    }

    // Get Image Height and Width

    $image = "../../Posts/${file_name}";

    
    // For jpg or jpeg files
    if($file_ext == "jpg" || $file_ext == "jpeg"){
        $image_data = exif_read_data($image, 0, true);
    
        //$date_taken = $image_data["FILE"]["FileDateTime"];
        $size = $image_data["FILE"]["FileSize"] / 1000000 . " MB";
        $width = $image_data["COMPUTED"]["Height"];
        $height = $image_data["COMPUTED"]["Width"];
    // For other files
    } else {
        list($width, $height) = getimagesize($image);
        $size = round((filesize($image) / 1000000), 3) . " MB";
        //echo $size;
        //$date_taken = "Not specified";
    }

    $image_name = $file_name;
    $date_posted = date("Y-m-d");
    $location = $_POST["location"];
    $category = $_POST["category"];
    $software = $_POST["software"];
    //$caption = $_POST["caption"];
    $views = 0;
    $downloads = 0;
    $username = $_SESSION["logged_in"];

    if($location == ""){
        $location = "Not Specified";
    }

    $sql_insert_data = "INSERT INTO photos(Username, Image_Name, Image_Size, Image_Width, Image_Height, Views, Downloads, Photo_Location, Photo_Posted, Category, Editing_Software) VALUES ('$username', '$image_name', '$size', $width, $height, $views, $downloads, '$location', '$date_posted', '$category', '$software')";
    $mysql->query($sql_insert_data);

    // Get ID of the upper insertion

    $get_id = "SELECT Photo_ID FROM photos WHERE Image_Name = '$image_name' AND Username = '$username'";
    $photo_id_result = $mysql->query($get_id)->fetch_assoc()["Photo_ID"];

    //mail("aljaz.loncaric2@gmail.com", "New Post", "Hello");

    // Emailing Functionality
    
    /*
    $get_followers_sql = "SELECT Follower FROM followers WHERE followed = '$username'";
    $result_followers = $mysql->query($get_followers_sql);

    if(mysqli_num_rows($result_followers) > 0){

        while($follower = $result_followers->fetch_assoc()){

            $follower_name = $follower["Follower"];

            //echo $follower_name . " ";

            $get_mail = "SELECT Email FROM users WHERE Username = '$follower_name'";
            $result_mail = $mysql->query($get_mail)->fetch_assoc()["Email"];

            //echo $result_mail . " ";

            $message = "
                @$username posted something new.
                Details available <a href='../../PhotoView/?id=$photo_id_result'>here</a>.
            ";

            //echo $message . " ";

            //$headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            //$headers .= 'From: sharephotos@gmail.com' . "\r\n";
            //$headers .= "Reply-To: aljaz.loncaric2@gmail.com \r\n";

            if(mail($result_mail, "New Post From @$username", $message, $headers)){
                echo "Email Sent";
            } else {
                echo "Email not sent";
            }

        }

        
    }

    */

    $mysql->close();

    header("location: ../../Home");

?>