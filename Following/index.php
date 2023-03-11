<?php
    session_start();

    if(!isset($_SESSION["logged_in"])){
        header("location: ../Login");
        die();
    }

    $follower = $_GET["follower"];
    $followed = $_GET["followed"];

    require '../Assets/connection.php';

    $insert_sql = "INSERT INTO followers (Followed, Follower) VALUES ('$followed', '$follower')";

    $mysql->query($insert_sql);

    $mysql->close();

    header("location: ../Profile/?user=". $followed);

?>