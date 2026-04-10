<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$pageTitle = "Bean Haven | Login";

if (!isset($_SESSION["login_failures"])) {
    $_SESSION["login_failures"] = 0;
}

$isLocked = $_SESSION["login_failures"] >= 3;
$isLoggedIn = isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true;
$message = "";
$messageClass = "";

if (isset($_GET["error"])) {
    $message = "Invalid username or password.";
    $messageClass = "error";
} elseif (isset($_GET["locked"])) {
    $message = "Too many login attempts. Login is disabled for this session.";
    $messageClass = "locked";
} elseif (isset($_GET["success"]) && $isLoggedIn) {
    $message = "Login successful. Welcome, " . htmlspecialchars($_SESSION["username"]);
    $messageClass = "success";
}
?>
<?php include 'header.php'; ?>

<section class="login-layout">
    <div class="login-panel login-copy">
        <p class="eyebrow">Member access</p>
        <h1>Sign in to unlock the full Bean Haven menu.</h1>
        <p>
            This page uses the shared class demo credentials and session tracking. After three failed attempts,
            the form is locked for the current session.
        </p>
        <div class="login-tip">
            <strong>Demo credentials</strong>
            <span>Username: jma</span>
            <span>Password: jma123</span>
        </div>
    </div>

    <div class="login-panel">
        <h2>Member Login</h2>
        <p class="login-subtext">Use the test account below to continue to the protected page.</p>

        <?php if ($message !== ""): ?>
            <div class="message <?php echo $messageClass; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($isLoggedIn): ?>
            <div class="account-state">
                Signed in as <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>.
                <a href="privatehome.php">Open member area</a>
            </div>
        <?php endif; ?>

        <form action="handler.php" method="POST" class="login-form">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" placeholder="Enter username" required <?php echo $isLocked ? "disabled" : ""; ?>>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="Enter password" required <?php echo $isLocked ? "disabled" : ""; ?>>

            <button type="submit" <?php echo $isLocked ? "disabled" : ""; ?>>Login</button>
        </form>

        <p class="hint">Failed attempts this session: <?php echo (int) $_SESSION["login_failures"]; ?></p>
    </div>
</section>

<?php include 'footer.php'; ?>
