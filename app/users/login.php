<?php
session_start();
// unset($_SESSION['error_msg']);
// ----------------- [ META DATA ] --------------------------------

$meta_title = "Login";
$meta_desc = "Here you'll sign into as a H4ck3r N3w5 publisher. Share your links and comment away till your hearts content!";
$meta_img = "../../assets/img/favicon.png";
$meta_card = "summary";
$meta_card_alt = "A newspaper made up of code";

// ----------------------------------------------------------------



// ----------------- [ Style sheets ] ----------------------------- 

$styles = [
    '../../assets/css/reset.css',
    '../../assets/css/defaults.css'
];

// ----------------------------------------------------------------


$title = "Login Page";

require "../../views/header.php";

if (isset($_SESSION['user'])) {
    header("Location: user.php");
}
// -----------------------------------------------------------------
?>





<main>
    <h1>Login to H4ck3r N3w5!</h1>
    <p>Please enter your login details into the form below or register for free!</p>

    <p class="success">
        <?php if (isset($_SESSION['success_msg'])) {
            echo $_SESSION['success_msg'];
        } ?>
    </p>
    <form action="../databases/db.php" method="post">
        <input type="hidden" value="sign in" name="task">
        <input type="text" placeholder="Mail" name="mail" required>
        <input type="password" placeholder="Password" name="password" required>
        <button type="submit" name="submit">Login!</button>
    </form>
    <a href="reg.php">Register for free!</a>
    <a href="https://1password.com/" target="_blank">Forgotten Password?</a>
    <p class="error">
        <?php if (isset($_SESSION['error_msg'])) {
            echo $_SESSION['error_msg'];
        } ?>
    </p>
</main>

<?php





// ----------------- [ Scripts ] ---------------------------------- 

$scripts = [
    '../../app/JS/navigator.js'
];

// ----------------------------------------------------------------



require "../../views/footer.php";
