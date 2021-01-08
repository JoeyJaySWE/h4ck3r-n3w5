<?php

require "../../views/functions.php";

if (!isset($_POST['submit'])) {
    abort_conection();
    die();
}


$_POST = form_sanitizer($_POST);

switch ($_POST['task']) {

    case "add user":
        if ($_POST['terms'] !== "on") {
            abort_conection();
        }
        add_new_user(db(), $_POST);
        break;


    case "sign in":
        echo "Sign in procees!";
        login(db(), $_POST);
        break;

    default:
        echo "Unkown form";
        break;
}
