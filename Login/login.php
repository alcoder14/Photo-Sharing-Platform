<?php

    session_start();

    if(isset($_SESSION["error-login"])){
        unset($_SESSION["error-login"]);
    }

    if(isset($_SESSION["logged_in"])){
        header("location: ../Home");
        die();
    }

    require("../Assets/connection.php");

    $username = mysqli_real_escape_string($mysql, $_POST["username"]);
    $password = mysqli_real_escape_string($mysql, $_POST["password"]);

    if(empty($username) || empty($password)){
        $message = "Some fields are empty";
        $_SESSION["error-login"] = $message;
        header("location: ../Login");
        die();
    }

    $check_username_sql = "SELECT Username FROM users WHERE Username = '$username'";

    $db_response_check_username = $mysql->query($check_username_sql);
    $num_rows = mysqli_num_rows($db_response_check_username);

    if($num_rows == 0){
        $message = "Account with this username does not exist.";
        $_SESSION["error-login"] = $message;
        header("location: /Login");
        die();
    }

    $check_password_sql = "SELECT password FROM users WHERE Username = '$username'";

    $db_response_password = $mysql->query($check_password_sql);
    $db_password = $db_response_password->fetch_assoc();
    $valid = password_verify($password, $db_password["password"]);

    if(!$valid){
        $message = "Password is not correct.";
        $_SESSION["error-login"] = $message;
        header("location: ../Login");
        die();
    }

    $mysql->close();

    $_SESSION["logged_in"] = $username;
    header("location: ../Home");

?>