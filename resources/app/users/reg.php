<?php

// ----------------- [ META DATA ] --------------------------------

$meta_title = "H4ck3r Sign up!";
$meta_desc = "Wanna join the comunity? Sign up today to be able to vote on links, leave comments, and upload your own.";
$meta_img = "../../assets/img/favicon.png";
$meta_card = "summary";
$meta_card_alt = "News paper made of code";
$title = "Sign up";

// ----------------------------------------------------------------


// ----------------- [ Style sheets ] ----------------------------- 

$styles = [
    '../../assets/css/reset.css',
    '../../assets/css/defaults.css'
];

// ----------------------------------------------------------------



$title = "Register new H4ck3r";

require  "../../views/header.php";


// -----------------------------------------------------------------
?>




<main>
    <h1>H4ck3r Sign Up</h1>
    <p>
        Sign up by entering your details in the form below and
        you may begin sharing your own links, vote on other links,
        and even comment on the links provided by other users.
    </p>
    <br>
    <form action="../databases/db.php" method="post">
        <input type="text" id="full_name" placeholder="Steven Stevenssen" required />
        <input type="email" name="email" placeholder="mail@mail.com" required />
        <input type="password" name="password" placeholder="password" required>
        <input type="hidden" name="task" value="add user" />
        <input type="password" name="re_password" placeholder="repeat password" required>
        <p>
            <input type="checkbox" name="terms" required> I hearby agree to the <a href="terms.php" target="_blank">Term and Conditions</a>.
        </p>
        <br>
        <button type="submit" name="submit">Register!</button>
    </form>
    <p class="error">
        <?php if (isset($_SESSION['error_msg'])) {
            echo $_SESSION['error_msg'];
        } ?>
    </p>
    <p class="success">
        <?php if (isset($_SESSION['success_msg'])) {
            echo $_SESSION['success_msg'];
        } ?>
    </p>
</main>





<?php
// ----------------- [ Scripts ] ---------------------------------- 

$scripts = [
    '../../app/JS/functions.js',
    '../../app/JS/navigator.js'
];

// ----------------------------------------------------------------

require "../../views/footer.php";
