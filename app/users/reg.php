<?php

// ----------------- [ META DATA ] ------------------

$meta_title = "H4ck3r Sign up!";
$meta_desc = "Wanna join the comunity? Sign up today to be able to vote on links, leave comments, and upload your own.";
$meta_img = "../../assets/img/favicon.png";
$meta_card = "summary";
$meta_card_alt = "News paper made of code";
$title = "Sign up";

// ----------------------------------------------------------------

require  "../../views/header.php";

?>

<main>
    <h1>H4ck3r Sign Up</h1>
    <p>
        Sign up by entering your details in the form below and
        you may begin sharing your own links, vote on other links,
        and even comment on the links provided by other users.
    </p>
    <form action="../databases/db.php" method="post">
        <input type="text" name="full_name" placeholder="Steven Stevenssen" required />
        <input type="email" name="email" placeholder="mail@mail.com" required />
        <input type="text" name="username" placeholder="username" required />
        <input type="password" name="password" placeholder="password" required>
        <input type="hidden" name="task" value="add user" />
        <input type="password" name="re_password" placeholder="repeat password" required>
        <input type="checkbox" name="terms" required> I hearby agree to the <a href="terms-and-conditions.php" target="_blank">Term and Conditions</a>.
        <button type="submit" name="submit">Register!</button>
    </form>
    <p class="error">
        <?php if (isset($_SESSION['error_msg'])) {
            echo $_SESSION['error_msg'];
        } ?>
    </p>
</main>


<?php
require "../../views/footer.php";
