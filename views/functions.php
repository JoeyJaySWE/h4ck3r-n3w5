<?php

declare(strict_types=1);

// ----------------- [ Abbort Conenction ] ------------------ 

function abort_conection(): void
{
    echo "Nice try, go back and fill in proper data :P";
    header("refresh:5; url=https://projects.joeyjaydigital.com/h4ck3r-n3w5/app/users/reg.php");
}

// ----------------------------------------------------------------





// ----------------- [ DB connection ] ------------------ 

function db()
{

    $dir = "sqlite:" . __DIR__ . "/../app/databases/h4ck3r.sqlite";
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

function form_sanitizer(array $post_data): array
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

function add_new_user($db, array $user_data): void
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

function login($db, array $credentials): void
{
    echo "<p>Inside the function{<p>";

    echo "<p>";
    print_r($credentials);
    echo "</p>";

    $mail = $_POST['mail'];
    $password = $_POST['password'];

    $find_user = $db->prepare("SELECT * FROM users WHERE Emails = :email");
    $data = [
        "email" => $mail
    ];
    $find_user->execute($data);

    $db_user = $find_user->fetchAll(PDO::FETCH_ASSOC);





    if (!$db_user) {
        session_start();
        $_SESSION['error_msg'] = "Password or Email missmatch, try again or <a href='reg.php'>Register for free!</a>";
        $_SESSION['success_msg'] = "";
        header("Location: ../users/login.php");
    }


    foreach ($db_user as $user) {
        if (password_verify($password, $user['Passwords'])) {
            session_start();
            $_SESSION['error_msg'] = "";
            $_SESSION['user'] = $user['Full_names'];
            $_SESSION['user_mail'] = $user['Emails'];
            $_SESSION['user_avatar'] = $user['Avatars'];
            $_SESSION['user_bio'] = $user['Bios'];
            $_SESSION['user_id'] = $user['Ids'];

            header("Location: ../users/user.php");
            break;
        } else {
            session_start();
            $_SESSION['error_msg'] = "Password or Email missmatch, try again or <a href='reg.php'>Register for free!</a>";
            $_SESSION['success_msg'] = "";
            die("Missmatch passwords");
            header("Location: ../users/login.php");
            break;
        }
    }

    echo "</p>}</p>";
}

// ----------------------------------------------------------------









// ----------------- [ Sign out ] ------------------ 

function log_out(): void
{
    session_start();
    session_destroy();
}

// ----------------------------------------------------------------







// ----------------- [ Update user  ] ------------------ 

function update_user($db, array $user): void
{
    session_start();
    echo "<p>";
    print_r($user);
    echo "</p>";
    echo "<p>";
    print_r($_SESSION);
    echo "</p>";

    $_SESSION['success_msgs'] = [];
    $_SESSION['error_msgs'] = [];

    $fname = $_POST['fname'];
    $mail = $_POST['email'];
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $avatar = $_POST['avatar'];
    $bio = $_POST['bio'];



    // Checks if we wanted to change the password
    if ($old_pass !== "" && $new_pass !== "" && $new_pass !== $old_pass) {

        $get_password = $db->prepare("SELECT Passwords FROM users WHERE Emails=:email");
        $query_data = [
            'email' => $_SESSION['user_mail']
        ];
        $get_password->execute($query_data);
        $db_passowrd = $get_password->fetch(PDO::FETCH_ASSOC);




        if (password_verify($old_pass, $db_passowrd['Passwords'])) {

            $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
            $update_password = $db->prepare("UPDATE users SET Passwords = :new_pass WHERE Emails = :emails");

            $query_data = ['new_pass' => $new_pass, 'emails' => $_SESSION['user_mail']];

            try {
                $update_password->execute($query_data);

                // if we successfully replaced the password,
                // we want to sign out the user to make sure it knows the password.
                header("Location: ../users/log-out.php?update=true");
                die("Success x2!");
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
            }
        } else {
            $_SESSION['error_msgs'][] = "Found no match for listed Old Password.";
            header("Location: ../users/user.php?action=settings");
        }
    } else if ($old_pass == !"" xor $new_pass !== "") {
        $_SESSION['error_msgs'][] = "Please enter both the old password,
                                    and the one you want to change to.";
        header("Location: ../users/user.php?action=settings");
    }




    // Checks if we wanted to replace the Mail
    if ($mail !== "" && $mail !== $_SESSION['user_mail']) {
        $update_mail = $db->prepare("UPDATE users SET Emails = :new_email WHERE Emails = :old_email");
        $query_vairables = ['new_email' => $mail, 'old_email' => $_SESSION['user_mail']];
        try {

            $update_mail->execute($query_vairables);
            $_SESSION['success_msgs'][] = "New email Saved Successfully!";
            $_SESSION['user_mail'] = $mail;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
        }
    }


    // checks if we wanted to replace the / add an avatar
    if ($avatar !== "" && $avatar !== $_SESSION['user_avatar']) {
        $update_avatar = $db->prepare("UPDATE users SET Avatars = :new_avatar WHERE Emails = :email");
        $query_vairables = ['new_avatar' => $avatar, 'email' => $_SESSION['user_mail']];
        try {
            $update_avatar->execute($query_vairables);
            $_SESSION['success_msgs'][] = "Avatar Saved Successfully!";
            $_SESSION['user_avatar'] = $avatar;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
        }
    }



    // checks if we wanted to replace the / add a biography
    if ($bio !== "" && $bio !== $_SESSION['user_bio']) {
        $update_bio = $db->prepare("UPDATE users SET Bios = :new_bio WHERE Emails = :email");
        $query_vairables = ['new_bio' => $bio, 'email' => $_SESSION['user_mail']];
        try {
            $update_bio->execute($query_vairables);
            $_SESSION['success_msgs'][] = "Bio updated!";
            $_SESSION['user_bio'] = $bio;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
        }
    }



    // Checks if we wanted to replace the name we use in the posts.
    if ($fname !== "" && $fname !== $_SESSION['user']) {
        $update_bio = $db->prepare("UPDATE users SET Full_names = :new_fname WHERE Emails = :email");
        $query_vairables = ['new_fname' => $fname, 'email' => $_SESSION['user_mail']];
        try {
            $update_bio->execute($query_vairables);
            $_SESSION['success_msgs'][] = "Full name updated!";
            $_SESSION['user'] = $fname;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
        }
    }
    header("Location: ../users/user.php?action=settings");
}

// ----------------------------------------------------------------



// ----------------- [ Cehck link ] ------------------ 

function check_link($db, string $lnk): void
{
    $get_lnk = $db->prepare("SELECT Links FROM posts WHERE Links = :lnk");
    $link = ['lnk' => $lnk];
    try {
        $get_lnk->execute($link);
        $db_link = $get_lnk->fetchAll(PDO::FETCH_ASSOC);
        if (!$db_link) {
            session_start();
            $_SESSION['lnk_free'] = $lnk;
            unset($_SESSION['lnk_taken']);
            header("location: ../posts/new-post.php#post_form");
            die();
        } else {
            session_start();
            $_SESSION['lnk_taken'] = true;
            header("location: ../posts/new-post.php#post_form");
        }
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
    }
}

// ----------------------------------------------------------------





// ----------------- [ Add new Post to DB ] ------------------ 

function add_post($db, array $post_data): void
{

    session_start();
    $post_title = $post_data['title'];
    $user = $_SESSION['user_id'];
    $descr = $post_data['description'];
    $lnk = $post_data['lnk'];





    $add_post = $db->prepare("INSERT INTO posts
    (Titles, Authurs_id, Descriptions, Links, Links_visits, Published)
    VALUES
    (:title, :user, :descr, :lnk, :visit, :publish)");


    $data = [
        "title" => $post_title,
        "user" => $user,
        "descr" => $descr,
        "lnk" => $lnk,
        "visit" => 0,
        "publish" => date('Y-m-d, H:i')
    ];
    try {
        $add_post->execute($data);
        $_SESSION['error_msg'] = "";
        $_SESSION['success_msg'] = "";
        $get_post_id = $db->query("SELECT Ids FROM posts WHERE Links =:lnk");
        $data = ['lnk' => $lnk];
        try {

            $get_post_id->execute($data);
            $post_id = $get_post_id->fetchAll(PDO::FETCH_ASSOC);

            header("Location: ../posts/posts.php?post=" . $post_id[0]['Ids']);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
        }
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
    }
}

// ----------------------------------------------------------------




// ----------------- [ Get Post Data ] ------------------ 

function get_post($db, int $post_id): array
{

    // $post_id .= filter_var()
    $post_id = filter_var($post_id, FILTER_SANITIZE_NUMBER_INT);
    $post_data = [];


    $get_post = $db->prepare("SELECT * FROM posts WHERE Ids = :id");
    $query_data = ['id' => $post_id];
    $get_post->execute($query_data);
    $posts = $get_post->fetchALL(PDO::FETCH_ASSOC);
    if ($posts) {
        foreach ($posts as $post) {
            $post_data[] = $post;
        }
        // var_dump($post_data);
    }

    $get_name_img = $db->prepare("SELECT Full_names, Avatars FROM users WHERE Ids = :id");
    $query_data = ['id' => $post_data[0]['Authurs_id']];
    $get_name_img->execute($query_data);
    $name_img = $get_name_img->fetchALL(PDO::FETCH_ASSOC);
    if ($name_img) {
        $post_data[0]['Full_name'] = $name_img[0]['Full_names'];
        $post_data[0]['Avatar'] = $name_img[0]['Avatars'];
        return $post_data[0];
        die();
    } else {
        die("No name found: " . var_dump($name_img));
    }

    // return $post_data;
}

// ----------------------------------------------------------------




// ----------------- [ Add Visit ] ------------------ 

function add_visit($db, int $post_id): void
{
    $post_id = filter_var($post_id, FILTER_SANITIZE_NUMBER_INT);
    $visited_post = ['id' => $post_id];
    $get_visits = $db->prepare("SELECT Links_visits FROM posts WHERE Ids = :id");
    $get_visits->execute($visited_post);
    $vists = $get_visits->fetchALL(PDO::FETCH_ASSOC);
    if ($vists) {
        $visited = $vists[0]['Links_visits'];
    }

    $add_visit = $db->prepare("UPDATE posts SET Links_visits = :visits WHERE Ids=:id");
    $post = ['visits' => ++$visited, 'id' => $post_id];
    try {
        $add_visit->execute($post);
        die();
        header("Location: ../posts/posts.php?post=" . $post_id . "&visited=true");
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
    }
}

// ----------------------------------------------------------------