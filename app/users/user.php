<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: login.php");
}

// ----------------- [ META DATA ] ------------------

$meta_title = "User";
$meta_desc = "Access your settings, upload a post, check your post for comments, and many more useful tools.";
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


if (isset($_GET['action'])) {
    $title = "User Settings";
} else {

    $title = "User Page";
}

require "../../views/header.php";
// -----------------------------------------------------------------
?>







<main>
    <?php
    if (!isset($_GET['action'])) : ?>
        <img class="avatar" src="<?= $_SESSION['user_avatar']; ?>">
        <h1>Welcome <?= $_SESSION['user']; ?>!</h1>

        <h2 class="subtitle">What would you like to do today?</h2>

        <section class="quick_menue">
            <a class="quick_launch_card" href="../posts/new-post.php/">
                <figure>
                    <img src="../../assets/img/new_post.png" alt="new post">
                    <figcaption>Create new Post</figcaption>
                </figure>
            </a>
            <a class="quick_launch_card" href="../users/user.php?action=settings">
                <figure>
                    <img src="../../assets/img/user_settings.png" alt="Edit User Settings">
                    <figcaption>Edit User Settings</figcaption>
                </figure>
            </a>
        </section>



    <?php else : ?>

        <h1>User Settings</h1>

        <p>Here you can change some of your settings for your profile and webbsite.</p>

        <p class="error">
            <?php if (isset($_SESSION['error_msgs'], $_SESSION['success_msgs'])) : ?>
        <ul>
        <?php
                foreach ($_SESSION['error_msgs'] as $error_msg) {
                    echo "<li class='error'>" . $error_msg . "</li>";
                }
                foreach ($_SESSION['success_msgs'] as $success_msg) {
                    echo "<li>" . $success_msg . "</li>";
                }

            endif; ?>
        </ul>
        </p>

        <form action="../databases/db.php" method="post" class="users_form">
            <input type="hidden" name="task" value="update user">
            <label for="fname">Full name:</label><input type="text" id="fname" name="fname" placeholder="<?= $_SESSION['user']; ?>">
            <label for="email">Email adress:</label><input type="email" id="email" name="email" placeholder="<?= $_SESSION['user_mail']; ?>">
            <label for="old_password">Old Password:</label><input type="password" id="old_password" name="old_password">
            <label for="new_password">New Password:</label><input type="password" id="new_password" name="new_password">
            <label for="avatar"><a href="https://imgur.com/upload" target="_blank">URL for avatar:</a></label><input type="url" id="avatar" name="avatar" <?php if (isset($_SESSION['user_avatar'])) ?> placeholder="<?= $_SESSION['user_avatar']; ?>">
            <label for="bio">User Biography:</label><textarea id="bio" name="bio"><?php if (isset($_SESSION['user_bio'])) ?><?= $_SESSION['user_bio']; ?></textarea>
            <button type="submit" name="submit">Update!</button> <button class="cancel" formaction="user.php">Cancel!</button>

        </form>


    <?php endif; ?>
</main>







<?php

// ----------------- [ Scripts ] ------------------ 

$scripts = [
    '../../app/JS/navigator.js',
    '../../app/JS/functions.js'
];

// ----------------------------------------------------------------



require "../../views/footer.php";

?>