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

$title = "Delete account";

$error_msg = $_SESSION['error_msgs'] ?? '';
unset($_SESSION['error_msgs']);

require "../../views/header.php";
// -----------------------------------------------------------------
?>




<main>
    <article class="delete-account-container">

        <h1>Delete account</h1>

        <h2>Are you sure? If you continue you will delete your account along with all your posts, user info, scores and comments.</h2>

        <form action="../databases/db.php" method="POST">
            <input type="hidden" name="task" value="delete_account">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>" />
            <label for="password">Type in your password to continue. </label>
            <input type="password" name="password" id="password" />

            <label for="confirm-password">Confirm password</label>
            <input type="password" name="confirm-password" id="confirm password" />
            <button type="submit" name="submit" value="submit" class="delete">Delete account</button>
        </form>
        <?php if ($error_msg !== '') : ?>
            <h4>
                <?= $error_msg; ?>
            </h4>
        <?php endif ?>


    </article>
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
