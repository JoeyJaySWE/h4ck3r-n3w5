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

    case "update user":
        echo "Update user!";
        update_user(db(), $_POST);
        break;

    case "Create Post":
        echo "Create Post!";
        if ($_POST['title'] === "" && !isset($_POST['description']) && $_POST['lnk'] !== "") {
            echo "Check link";
            check_link(db(), $_POST['lnk']);
        } else if ($_POST['title'] !== "" && $_POST['description'] !== "" && $_POST['lnk'] !== "") {
            echo "Add Post!";
            add_post(db(), $_POST);
        } else {
            $_SESSION['error_msgs'] = "Please fill in all fields properly.";
            header("Location: ../posts/new-post.php#post_form");
            die();
        }

        break;

    default:
        echo "Unkown form";
        break;
}
