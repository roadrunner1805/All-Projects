<?php
$pageTitle = "Bean Haven | Home";

$coffees = [
    [
        "name" => "Latte",
        "description" => "An espresso shot combined with steamed milk and a small layer of foam, often considered a staple creamy coffee choice."
    ],
    [
        "name" => "Cappuccino",
        "description" => "Composed of equal parts espresso, steamed milk, and milk foam, offering a stronger coffee taste than a latte."
    ],
    [
        "name" => "Americano",
        "description" => "Made by diluting a shot of espresso with hot water, resulting in a drink similar in strength to regular drip coffee but with a different flavor profile."
    ],
    [
        "name" => "Espresso",
        "description" => "The concentrated base for most coffee drinks, served as a single or double shot."
    ]
];
?>

<?php include 'header.php'; ?>

<section class="hero">
    <div class="hero-left">
        <p class="eyebrow">Campus coffee, polished for presentation</p>
        <h1>BREWING AND SERVING COFFEE WITH HEART.</h1>
        <p>
            Bean Haven is your cozy coffee stop for rich espresso drinks, warm flavors,
            and simple moments worth slowing down for. Freshly crafted coffee, served daily.
        </p>
        <div class="hero-buttons">
            <a href="login.php">Member Login</a>
            <a href="#featured" class="secondary">View Menu</a>
        </div>
    </div>

    <div class="hero-right">
        <div class="hero-badge">Freshly Roasted</div>
        <div class="coffee-cup" aria-hidden="true">
            <div class="steam">~~~</div>
            <div class="coffee-band">BEAN HAVEN</div>
        </div>
    </div>
</section>

<section class="menu-section" id="featured">
    <h2>OUR FEATURED COFFEES</h2>
    <p class="menu-subtext">
        Explore four classic coffee favorites at Bean Haven, from smooth and creamy to bold and strong.
    </p>

    <div class="coffee-grid">
        <?php foreach ($coffees as $coffee): ?>
            <div class="coffee-card">
                <h3><?php echo htmlspecialchars($coffee["name"]); ?></h3>
                <p><?php echo htmlspecialchars($coffee["description"]); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="about-section" id="about">
    <div class="about-card">
        <h2>Why This Demo Works</h2>
        <p>
            The public homepage introduces the brand, the login page handles authentication with session tracking,
            and the protected member area reveals the expanded menu only after a successful sign-in.
        </p>
    </div>
    <div class="about-card accent">
        <h2>Presentation Flow</h2>
        <p>
            Start on the homepage, sign in with the demo account, then open the private page to show protected content and logout support.
        </p>
    </div>
</section>

<?php include 'footer.php'; ?>
