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
</main>


<?php

// ----------------- [ Scripts ] ---------------------------------- 

$scripts = [
    '../../app/JS/navigator.js'
];

// ----------------------------------------------------------------


require "views/footer.php";

?>