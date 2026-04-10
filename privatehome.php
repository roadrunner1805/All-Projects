<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$pageTitle = "Bean Haven | Member Area";

// Security: Prevent direct URL access
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<?php include 'header.php'; ?>

<section class="member-hero">
    <div>
        <p class="eyebrow">Private member area</p>
        <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>.</h1>
        <p>As a signed-in member, you now have access to all eight signature Bean Haven drinks.</p>
    </div>
    <a class="member-action" href="logout.php">Log Out</a>
</section>

<section class="content">
    <div class="welcome">
        <h2>Full Coffee Menu</h2>
        <p>These extra drinks only appear after the session check passes.</p>
    </div>

    <div class="coffee-grid">
        <div class="coffee-card">
            <h3>Latte</h3>
            <p>An espresso shot combined with steamed milk and a small layer of foam.</p>
        </div>
        <div class="coffee-card">
            <h3>Cappuccino</h3>
            <p>Composed of equal parts espresso, steamed milk, and milk foam.</p>
        </div>
        <div class="coffee-card">
            <h3>Americano</h3>
            <p>Made by diluting a shot of espresso with hot water.</p>
        </div>
        <div class="coffee-card">
            <h3>Espresso</h3>
            <p>The concentrated base for most coffee drinks.</p>
        </div>

        <!-- 4 Additional coffees for logged-in users -->
        <div class="coffee-card">
            <h3>Nitro Cold Brew</h3>
            <p>Smooth and creamy cold brew infused with nitrogen.</p>
        </div>
        <div class="coffee-card">
            <h3>Flat White</h3>
            <p>Velvety microfoam with a rich espresso shot.</p>
        </div>
        <div class="coffee-card">
            <h3>Mocha</h3>
            <p>Espresso with steamed milk and rich chocolate syrup.</p>
        </div>
        <div class="coffee-card">
            <h3>Pour Over</h3>
            <p>Single-origin pour over coffee – bright and complex.</p>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
