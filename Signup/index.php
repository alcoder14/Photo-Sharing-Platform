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
    <title>Sign up</title>
</head>
<body>
    <section class="signup-container">
        <form action="signup.php" method="post" class="signup-form">
            <h1 class="title">Sign Up</h1>
            <div class="blue-line"></div>
            <?php if(isset($_SESSION["error"])): ?>
                <div class="error"><?php echo $_SESSION["error"]; ?></div>
            <?php endif; ?>
            <div class="input-grid">
                <input type="text" name="firstname" placeholder="First Name" class="input">
                <input type="text" name="lastname" placeholder="Last Name" class="input">
                <input type="email" name="email" placeholder="Email" class="input">
                <input type="text" name="username" placeholder="Username" class="input">
                <input type="password" name="password" placeholder="Password" class="input">
                <input type="password" name="repeat-password" placeholder="Repeat Password" class="input">
            </div>
            <button type="submit" class="submit-btn">Submit</button>
            <div class="bottom-line">
                <h3 class="already_member">Already a member?</h3>
                <a href="../Login"><button class="no-account-btn" type="button">Log In</button></a>
            </div>
        </form>
    </section>
</body>
</html>