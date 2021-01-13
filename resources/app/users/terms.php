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
    '../../assets/css/defaults.css',
    '../../assets/css/terms.css'
];

// ----------------------------------------------------------------


$title = "Terms and Conditions";

require "../../views/header.php";


// -----------------------------------------------------------------
?>


<main>
    <h2>Terms & Conditions</h2>

    <p>As you register for a H4ck3r N3w5 account,
        you are agreeing to the following conditions listed below
    </p>
    <ol>
        <li>The users themselves are responsible for all uploaded content found on H4ck3r N3w5.</li>
        <li>Content should be free of any type of pornographical content. If this is more to your liking, we suggest you look some place else.</li>
        <li>Content should not be offensive. We're here to help share information, not participate in cyberbullying.</li>
        <li>H4ck3 N3w5 are a none-profit site, and as such, we don't want our users to abuse the site for comersial gain.</li>
    </ol>
    <strong>If any of the IV tenents above is breached, H4ck3r N3w5 serves the right to remove any such post or comment,
        and depending on the degree of violation responsible user might also be served with a ban from a month to life time.
        If violation is extream enough to be considered a matter for the court, H4ck3r N3w5 will be forced to hand over any relevant user
        data in order to help move the case forward (this can be all from user comments, posts, mail, name, etc.).
    </strong>
</main>


<?php
// ----------------- [ Scripts ] ------------------ 

$scripts = [
    '../../app/JS/functions.js',
    '../../app/JS/navigator.js'
];

// ----------------------------------------------------------------



require "../../views/footer.php";

?>