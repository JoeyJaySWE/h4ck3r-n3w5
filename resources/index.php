<?php
session_start();
// ------------------- [ HEADER DATA ] -----------------------------

$title = "H4ck3r N3w5";
$metaTitle = "H4ck3r N3w5";
$metaDesc = "Hacker News a site where you can share your latest links for usueful tools or stuff.";
$metaImg = "./assets/img/favicon.png";
$metaCard = "summary";
$metaCardAlt = "A news paper made of code";


// ----------------------------------------------------------------




// ----------------- [ Style sheets ] ----------------------------- 

$styles = [
    '../../assets/css/reset.css',
    '../../assets/css/defaults.css'
];

// ----------------------------------------------------------------




require "views/header.php";
// -----------------------------------------------------------------
?>


<main>
    <h1>H4ck3r N3w5</h1>
    <p class="subtitle">
        Your one stop shop for the sharing the latest of big three W.
        Sign up today to join the comunity and share your findings!
    </p>
    <br>
    <?php if (isset($_SESSION['user'])) : ?>
        <a href="/app/users/user.php?action=settings">Change Settings!</a>
        <br>
        <br>
        <a href="/app/posts/posts.php">Check the news feed!</a>
    <?php else : ?>
        <a href="/app/users/reg.php">Register for Free!</a>
        <br>
        <br>
        <a href="/app/users/login.php">Already a user? Sign in here!</a>
    <?php endif; ?>
    <div class="bottom_anchor">
        <img src="https://media.discordapp.net/attachments/488482156704825348/798263922091098202/favicon.png" alt="Hacker News logo">
        <strong>H4ck3r N3w5</strong>
    </div>
</main>


<?php

// ----------------- [ Scripts ] ---------------------------------- 

$scripts = [
    '../../app/JS/functions.js',
    '../../app/JS/navigator.js'
];

// ----------------------------------------------------------------


require "views/footer.php";

?>