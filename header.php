<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$pageTitle = $pageTitle ?? "Bean Haven";
$isLoggedIn = isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true;
$currentPage = basename($_SERVER["PHP_SELF"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <a class="logo" href="index.php">
            BEAN<br>HAVEN
            <span>C.O.F.F.E.E.</span>
        </a>

        <nav class="site-nav">
            <ul>
                <li><a href="index.php" class="<?php echo $currentPage === "index.php" ? "active" : ""; ?>">Home</a></li>
                <li><a href="index.php#featured">Featured</a></li>
                <li><a href="index.php#about">About</a></li>
                <?php if ($isLoggedIn): ?>
                    <li><a href="privatehome.php" class="<?php echo $currentPage === "privatehome.php" ? "active" : ""; ?>">Member Area</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="<?php echo $currentPage === "login.php" ? "active" : ""; ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
