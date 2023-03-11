<?php   

    session_start();

    include '../Assets/connection.php';

    $id = $_GET["id"];
    $image_name = $_GET["image_name"];

    $delete_post_sql = "DELETE FROM photos WHERE Photo_ID= $id";
    $mysql->query($delete_post_sql);

    unlink("../Posts/{$image_name}");

    $mysql->close();

    header("location: ../Profile/?user=" . $_SESSION['logged_in']);
?>