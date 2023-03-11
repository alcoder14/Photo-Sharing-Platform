<?php 
    session_start();
    include '../Assets/connection.php';

    $photo_id = $_SESSION["photo_active"];
    $user_commented = $_SESSION["logged_in"];
    $comment = $_POST["comment"];
    $comment_posted = date("Y-m-d H:i:sa");

    $insert_comment_sql = "INSERT INTO comments(Photo_ID, User_commented, Comment_Posted, Comment) VALUES ($photo_id, '$user_commented', '$comment_posted', '$comment')";

    $mysql->query($insert_comment_sql);

    $mysql->close();
    header("location: ../PhotoView/?id=" . $photo_id);
?>