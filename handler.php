<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION["login_failures"])) {
    $_SESSION["login_failures"] = 0;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$username = trim($_POST["username"] ?? "");
$password = trim($_POST["password"] ?? "");

if ($_SESSION["login_failures"] >= 3) {
    header("Location: login.php?locked=1");
    exit;
}

if ($username === "jma" && $password === "jma123") {
    $_SESSION["logged_in"] = true;
    $_SESSION["username"] = $username;
    $_SESSION["login_failures"] = 0;

    header("Location: privatehome.php");
    exit;
}

$_SESSION["logged_in"] = false;
$_SESSION["login_failures"]++;

$redirect = $_SESSION["login_failures"] >= 3 ? "login.php?locked=1" : "login.php?error=1";
header("Location: " . $redirect);
exit;
