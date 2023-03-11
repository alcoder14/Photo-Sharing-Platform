<?php 

    session_start();
    include "../Assets/connection.php";

    $id = $_GET["comment_id"];

    $delete_comment = "DELETE FROM comments WHERE Comment_ID = $id";
    $mysql->query($delete_comment);

    $mysql->close();
    
    header("location: ../PhotoView/?id=" . $_SESSION["photo_active"]);

?>