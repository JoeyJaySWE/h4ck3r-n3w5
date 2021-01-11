<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: login.php");
}


if (!isset($_SESSION['new-post'])) {
    $_SESSION['new-post'] = [];
}



// ----------------- [ META DATA ] ------------------

$meta_title = "Creat Post!";
$meta_desc = "This is the heart and soul of H4ck3r N3w5. Here you upload your links and become part of the comunity.";
$meta_img = "../../assets/img/favicon.png";
$meta_card = "summary";
$meta_card_alt = "A newspaper made up of code";

// ----------------------------------------------------------------


// ----------------- [ Style sheets ] ------------------ 
$styles = [
    '../../../assets/css/reset.css',
    '../../../assets/css/defaults.css',
    '../../../assets/css/post.css'
];

// ----------------------------------------------------------------



$title = "Create Post";

require "../../views/header.php";
// unset($_SESSION['lnk_free']);
// unset($_SESSION['lnk_taken']);

// -----------------------------------------------------------------
?>

<main>
    <h1>Create your own Post!</h1>

    <p>
        This is the heart and soul of H4ck3r N3w5.
        Here you upload your links and become part of the comunity.
        Make sure to fill out all the fields below.
    </p>

    <p class="error">
        <?php if (isset($_SESSION['new-post']['lnk_taken'])) {

            echo "Link already uploaded, try something else.";
        } else if (isset($_SESSION['new-post']['error_msgs'])) {
            foreach ($_SESSION['new-post']['error_msgs'] as $error) {
                echo $error;
            }
        } ?>

    </p>
    <form action="/app/databases/db.php" method="post" class="users_form">
        <input type="hidden" name="task" value="Create Post">
        <label for="lnk">Link to share:</label>
        <input type="url" id="lnk" name="lnk" <?php if (isset($_SESSION['new-post']['lnk_free'])) echo "value='" . $_SESSION['new-post']['lnk_free'] . "' required"; ?>>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title">
        <?php

        if (!isset($_SESSION['new-post']['lnk_free'], $_GET['new_lnk'])) : ?>

            <label for="description" disabled>Description:</label>
            <textarea id="lnk" name="lnk" disabled></textarea>
            <button type="submit" name="submit">Create!</button>
            <button class="cancel" formnovalidate formaction="../users/user.php">Cancel</button>
        <?php
        else : ?>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <button type="submit" name="submit">Create!</button>
            <button class="cancel" formnovalidate formaction="/app/users/user.php">Cancel</button>
        <?php endif; ?>
    </form>
</main>


<?php

// ----------------- [ Scripts ] ------------------ 

$scripts = [
    '/app/JS/navigator.js',
    '/app/JS/functions.js',
    '/app/JS/link_check.js'
];

// ----------------------------------------------------------------



require "../../views/footer.php";

?>