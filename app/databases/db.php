<?php

require "../../views/functions.php";

if ($_POST['terms'] !== "on" xor !isset($_POST['submit'])) {
    echo "Nice try, go back and fill in proper data :P";
    header("refresh:5; url=https://projects.joeyjaydigital.com/h4ck3r-n3w5/app/users/reg.php");
    die();
}


$_POST = form_sanitizer($_POST);

if ($_POST['task'] === "add user") {
    add_new_user(db(), $_POST);

    // db();
}
