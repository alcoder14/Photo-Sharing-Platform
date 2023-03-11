<header class="mobile-header">
    <div class="icons-container">
        <div class="icons-left-side">
            <i class="fa-solid fa-plus mobile-icon"></i>
        </div>
        <div class="icons-mid-side">
            <?php if($_SESSION["navbar-identifier"] ==  "Home"): ?>
                <a href="../Home"><i class="fa-regular fa-image  mobile-icon chosen"></i></a>
                <a href="../Users"><i class="fa-solid fa-users mobile-icon"></i></i></a>
            <?php else: ?>
                <a href="../Home"><i class="fa-regular fa-image  mobile-icon"></i></a>
                <a href="../Users"><i class="fa-solid fa-users mobile-icon chosen"></i></i></a>
            <?php endif; ?>
        </div>
        <div class="icons-right-side">
            <a href="../Server/logout.php" class="mobile-icon"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
    </div>
</header>