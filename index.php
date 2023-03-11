<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <?php require "Assets/links.php"; ?>
    <title>Welcome</title>
</head>
<body>
    <?php
        if(isset($_SESSION["logged_in"])){
            header("location: Home");
        }
    ?>
    <section class="container">

        <div class="left">
            <div class="orange-line"></div>
            <h1 class="text">Share photos.</h1>
            <h1 class="text">Anywhere.</h1>
            <h1 class="text">Anytime.</h1>

            <a href="Signup"><button class="option orangewhite">Sign Up</button></a>
            <a href="Login"><button class="option whiteorange">Log In</button></a>
            <a href="Home"><button class="option orangeblack">Visitor</button></a>

        </div>
        <div class="right">
            <img src="Images/computerphone.png" class="photo">
        </div>
    </section>
</body>
</html>