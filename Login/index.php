<?php
    session_start();
    if(isset($_SESSION["logged_in"])){
        header("location: ../Home");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <?php require '../Assets/links.php' ?>
    <title>Login</title>
</head>
<body>
    <section class="login-container">
        <form action="login.php" method="post" class="login-form">
            <h1 class="title">Log In</h1>
            <div class="blue-line"></div>
            <?php if(isset($_SESSION["error-login"])): ?>
                <div class="error"><?php echo $_SESSION["error-login"]; ?></div>
            <?php endif; ?>
            <input type="text" placeholder="Username" name="username" class="input top">
            <input type="password" placeholder="Password" name="password" class="input">
            <button type="submit" class="submit-btn">Log In</button>
            <div class="bottom-line">
                <h3 class="not_member">Not a member yet?</h3>
                <a href="../Signup"><button class="account-btn" type="button">Sign Up</button></a>
            </div>
        </form>
    </section>
</body>
</html>