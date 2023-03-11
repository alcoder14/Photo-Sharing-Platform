<?php
    session_start();

    if(!isset($_SESSION["logged_in"])){
        header("location: ../Login");
        die();
    }

    $follower = $_GET["follower"];
    $followed = $_GET["followed"];

    require '../Assets/connection.php';

    $delete_following_relation = "DELETE FROM followers WHERE Followed = '$followed' AND Follower = '$follower'";

    $mysql->query($delete_following_relation);

    $mysql->close();

    header("location: ../Profile/?user=". $followed);

?>