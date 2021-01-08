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
    '../../../assets/css/reset.css',
    '../../../assets/css/defaults.css',
    '../../../assets/css/user-page.css'
];

// ----------------------------------------------------------------



$title = "User Page";

require "../../views/header.php";
// -----------------------------------------------------------------
?>



<main>
    <h1>User Settings</h1>
</main>





<?php

// ----------------- [ Scripts ] ------------------ 

$scripts = [
    '../../app/JS/navigator.js'
];

// ----------------------------------------------------------------



require "../../views/footer.php";

?>