<?php

// declare(strict_type=1);


// ----------------- [ DB connection ] ------------------ 

function db()
{

    $dir = "sqlite:h4ck3r.sqlite";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $db = new PDO($dir, "", "",  $options); //tries to connect to our databse using $path, $username, $passowrd, $options 
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
    }


    return $db;
}

// ----------------------------------------------------------------








// ----------------- [ Sanitize form inputs ] ------------------ 

function form_sanitizer(array $post_data)
{
    $filtered_data = [];
    foreach ($post_data as $key => $value) {
        if ($key === "submit") {
            continue;
        }

        $trimmed = filter_var(trim($post_data[$key]), FILTER_SANITIZE_EMAIL);

        if (filter_var($trimmed, FILTER_VALIDATE_EMAIL)) {
            $filtered_data[$key] = $trimmed;
        } else {
            $filtered_data[$key] = filter_var(trim($post_data[$key]), FILTER_SANITIZE_STRING);
        }
    }
    return $filtered_data;
}

// ----------------------------------------------------------------








// ----------------- [ Add New User ] ------------------------------ 

function add_new_user($db, array $user_data)
{
    session_start();

    // check if user already exxsists
    $get_users = $db->prepare("SELECT Emails FROM users WHERE Emails = :email");
    $data = ["email" => $user_data['email']];
    $get_users->execute($data);
    $row = $get_users->fetchAll(PDO::FETCH_ASSOC);
    if ($row) {
        $_SESSION['error_msg'] = "Email adress already in usedddd!";
        $_SESSION['success_msg'] = "";
        header("Location: http://localhost:8000/app/users/reg.php");
        die("error");
    } else {





        $fname = $_POST['full_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $re_password = $_POST['re_password'];


        // password match check
        if ($password !== $re_password) {

            $_SESSION['error_msg'] = "Passwords missmatch!";
            $_SESSION['success_msg'] = "";
            header("Location: http://localhost:8000/app/users/reg.php");
            die("password error");
        }







        // adds user
        else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $add_user = $db->prepare("INSERT INTO users
                                    (Emails, Passwords, Avatars, Bios, Joined, Full_names)
                                    VALUES
                                    (:email, :password, :avatar, :bio, :joined, :fname)");


            $data = [
                "email" => $email,
                "password" => $password,
                "avatar" => "",
                "bio" => "",
                "joined" => date('Ymd'),
                "fname" => $fname
            ];
            try {
                $add_user->execute($data);
                $_SESSION['error_msg'] = "";
                $_SESSION['success_msg'] = "Successfully created user!";
                header("Location: http://localhost:8000/app/users/reg.php");
                die("Success!");
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
            }
        }
    }
}

// ----------------------------------------------------------------









// ----------------- [ Log In Function ] ------------------ 

    // add Code here.....

// ----------------------------------------------------------------