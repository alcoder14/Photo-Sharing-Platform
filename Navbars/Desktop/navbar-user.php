<nav class="navbar">
    <div class="left-side">
        <i class="fa-solid fa-plus navbar-icon" id="add-photo"></i>
    </div>
    <div class="mid-side">

        <?php if($_SESSION["navbar-identifier"] ==  "Home"): ?>
            <a href="../Home"><i class="fa-regular fa-image navbar-icon chosen"></i></a>
            <a href="../Users"><i class="fa-solid fa-users navbar-icon"></i></i></a>

        <?php elseif($_SESSION["navbar-identifier"] == "Users"): ?>
            <a href="../Home"><i class="fa-regular fa-image navbar-icon"></i></a>
            <a href="../Users"><i class="fa-solid fa-users navbar-icon chosen"></i></i></a>
        <?php else: ?>
            <a href="../Home"><i class="fa-regular fa-image navbar-icon"></i></a>
            <a href="../Users"><i class="fa-solid fa-users navbar-icon"></i></i></a>
        <?php endif; ?>

    </div>
    <div class="right-side">
        <?php if($_SESSION["navbar-identifier"] ==  "Profile"): ?>
            <a href="../Profile/?user=<?php echo $_SESSION['logged_in']; ?>"><i class="fa-solid fa-user navbar-icon chosen"></i></a>
        <?php else: ?>
            <a href="../Profile/?user=<?php echo $_SESSION['logged_in']; ?>"><i class="fa-solid fa-user navbar-icon "></i></a>
        <?php endif; ?>

        <a href="../Server/logout.php"><i class="fa-solid fa-right-from-bracket navbar-icon"></i></a>
    </div>
</nav>