<?php

require "../../views/functions.php";

if ($_POST['terms'] !== "on" || !isset($_POST['submit'])) {
    echo "Nice try, go back and fill in proper data :P";
    header("refresh:5; url=https://projects.joeyjaydigital.com/h4ck3r-n3w5/app/users/reg.php");
    die();
}


$_POST = form_sanitizer($_POST);
