<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<link rel="stylesheet" href="css/styles.css">
<div class="container menu-container">
<nav class="navbar">
    <a class="navbar-brand" href="index.php"><span>Muamalah Repository</span></a>
        <ul class="nav-menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="#search-section" onclick="checkLogin()">Search</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="https://muamalah.uinsu.ac.id">Contact</a></li>
            <?php if (isset($_SESSION['student_id'])): ?>
            <li>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
        </ul>
    </nav>
</div>
