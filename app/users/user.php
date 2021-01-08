<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: login.php");
}

// ----------------- [ META DATA ] ------------------

$meta_title = "Login";
$meta_desc = "Here you'll sign into as a H4ck3r N3w5 publisher. Share your links and comment away till your hearts content!";
$meta_img = "../../assets/img/favicon.png";
$meta_card = "summary";
$meta_card_alt = "A newspaper made up of code";

// ----------------------------------------------------------------


// ----------------- [ Style sheets ] ------------------ 
$styles = [
    '../../assets/css/reset.css',
    '../../assets/css/defaults.css',
    '../../assets/css/user-page.css'
];

// ----------------------------------------------------------------



$title = "User Page";

require "../../views/header.php";
// -----------------------------------------------------------------
?>







<main>
    <h1>Welcome <?= $_SESSION['user']; ?>!</h1>

    <h2 class="subtitle">What would you like to do today?</h2>

    <section class="quick_menue">
        <a class="quick_launch_card" href="../posts/new-post.php/">
            <figure>
                <img src="https://via.placeholder.com/128?text=New+Post" alt="new post">
                <figcaption>Create new Post</figcaption>
            </figure>
        </a>
        <a class="quick_launch_card" href="../posts/posts?action=edit.php/">
            <figure>
                <img src="https://via.placeholder.com/128?text=Edit+Posts" alt="Edit Posts">
                <figcaption>Edit Posts</figcaption>
            </figure>
        </a>


        <a class="quick_launch_card" href="../posts/posts?action=remove.php/">
            <figure>
                <img src="https://via.placeholder.com/128?text=Remove+Post" alt="remove posts">
                <figcaption>Remove Posts</figcaption>
            </figure>
        </a>
        <a class="quick_launch_card" href="../users/user-settings.php/">
            <figure>
                <img src="https://via.placeholder.com/128?text=Edit+User+Settings" alt="Edit User Settings">
                <figcaption>Edit User Settings</figcaption>
            </figure>
        </a>
    </section>
</main>







<?php

// ----------------- [ Scripts ] ------------------ 

$scripts = [
    '../../app/JS/navigator.js'
];

// ----------------------------------------------------------------



require "../../views/footer.php";

?>