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
        login(db(), $_POST);
        break;

    case "update user":
        update_user(db(), $_POST);
        break;

    case "Create Post":
        if ($_POST['title'] === "" && !isset($_POST['description']) && $_POST['lnk'] !== "") {
            check_link(db(), $_POST['lnk']);
            die();
        } else if ($_POST['title'] !== "" && $_POST['description'] !== "" && $_POST['lnk'] !== "") {

            add_post(db(), $_POST);
            die();
        } else {
            $_SESSION['error_msgs'] = "Please fill in all fields properly.";
            header("Location: ../posts/new-post.php#post_form");
            die();
        }

        break;

    case "vote":
        session_start();
        if ($_POST['update'] !== "true") {
            vote(db(), (int)$_POST['post_id'], (int)$_SESSION['user_id'], (int)$_POST['score'], $_POST['update']);
        } else {

            vote(db(), (int)$_POST['post_id'], (int)$_SESSION['user_id'], (int)$_POST['score'], $_POST['update']);
        }
        break;

    case "edit_post":
        if ($_POST['title'] !== "" && $_POST['description'] !== "") {
            update_post(db(), $_POST);
            die();
        } else {
            session_start();
            $_SESSION['error_msgs'] = "Please fill in all fields properly.";
            header("Location: ../posts/posts.php?post=" . $_POST['post_id'] . "&action=edit");
            die();
        }
        break;

    case "add_comment":
        var_dump("Comment");
        manage_comment(db(), $_POST, "Add");
        break;

    case "edit_comment":
        manage_comment(db(), $_POST, "Edit");
        break;

    default:
        die(var_dump($_POST['task']));
        break;
}
