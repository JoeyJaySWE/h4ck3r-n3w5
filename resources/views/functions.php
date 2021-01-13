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
        } else if (filter_var($trimmed, FILTER_VALIDATE_INT)) {

            $filtered_data[$key] = filter_var(trim($post_data[$key]), FILTER_SANITIZE_NUMBER_INT);
        } else if (filter_var($trimmed, FILTER_VALIDATE_URL)) {
            $filtered_data[$key] = filter_var(trim($post_data[$key]), FILTER_SANITIZE_URL);
        } else {
            $filtered_data[$key] = filter_var(trim($post_data[$key]), FILTER_SANITIZE_STRING);
        }
    }
    return $filtered_data;
}

// ----------------------------------------------------------------




// ----------------- [ Get Title ] ------------------ 

function get_title()
{


    if (isset($_GET['post'])) {
        if (isset($_GET['action'])) {


            $title = "Edit ";
        }
    } else {
        $title = "N3ws Pots";
    }


    return $title;
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
        header("Location: ../users/reg.php");
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
            header("Location: ../users/reg.php");
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
                "avatar" => "https://media.discordapp.net/attachments/488482156704825348/798263922091098202/favicon.png",
                "bio" => "",
                "joined" => date('Ymd'),
                "fname" => $fname
            ];
            try {
                $add_user->execute($data);
                $_SESSION['error_msg'] = "";
                $_SESSION['success_msg'] = "Successfully created user!";
                header("Location: ../users/login.php");
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
            $_SESSION['new-post']['lnk_free'] = $lnk;
            unset($_SESSION['new-post']['lnk_taken']);
            header("location: ../posts/new-post.php?new_lnk=true");
            die();
        } else {
            session_start();
            $_SESSION['new-post']['lnk_taken'] = true;
            header("location: ../posts/new-post.php?new_lnk=false");
            die();
        }
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
    }
}

// ----------------------------------------------------------------





// ----------------- [ Add new Post ] ------------------ 

function add_post($db, array $post_data): void
{

    session_start();
    $post_title = $post_data['title'];
    $user = $_SESSION['user_id'];
    $descr = $post_data['description'];
    $lnk = $post_data['lnk'];

    // check if user included an end "/" if not, we add it for them.
    $lnk_length = strlen($lnk);
    if (!strpos($lnk, "/", --$lnk_length)) {
        $lnk .= "/";
    }




    $process_post = $db->prepare("INSERT INTO posts
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
        $process_post->execute($data);

        $get_post_id = $db->query("SELECT Ids FROM posts WHERE Links =:lnk");
        $data = ['lnk' => $lnk];
        try {

            $get_post_id->execute($data);
            $post_id = $get_post_id->fetchAll(PDO::FETCH_ASSOC);

            $add_score = $db->prepare("INSERT INTO scores (Posts_id, Users_id, Scores) VALUES (:post, :authur, :score)");
            $score_data = [
                'post' => $post_id[0]['Ids'],
                'authur' => $user,
                'score' => 1
            ];

            try {

                $add_score->execute($score_data);
                $_SESSION['new-post']['error_msg'] = "";
                $_SESSION['new-post']['success_msg'] = "";
                header("Location: ../posts/posts.php?post=" . $post_id[0]['Ids']);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
            }
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
        }
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
    }
}

// ----------------------------------------------------------------








// ----------------- [ Update Post ] ------------------------------



function update_post($db, array $post_data): void
{
    $post_title = $post_data['title'];
    $descr = $post_data['description'];
    $post_id = $post_data['post_id'];

    print_r($post_data);
    var_dump($post_title);
    var_dump($descr);
    var_dump($post_id);
    var_dump(print_r($post_data));
    $update_post = $db->prepare("UPDATE posts 
                                SET Titles = :post_title,
                                Descriptions = :descr
                                WHERE Ids = :Ids");
    $query_data = ['post_title' => $post_title, 'descr' => $descr, 'Ids' => $post_id];

    try {
        $update_post->execute($query_data);
        header("Location: ../posts/posts.php?post=" . $post_id);
        die();
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
    }
}




// ----------------------------------------------------------------









// ----------------- [ Get Post Data ] ------------------ 

function get_post($db, int $post_id, string $all = null, string $order = null, string $direction = null): array
{
    if ($all === "*") {


        if ($order !== NULL) {
            switch ($order) {
                case "Published":
                    $sort = "ORDER BY posts." . $order;
                    break;
                case "Full_names":
                    $sort = "ORDER BY users." . $order;
                    break;
                case "Scores":
                    $sort = "ORDER BY " . $order;
                    break;
            }
        } else {
            $sort = null;
        }
        $get_posts = $db->query("SELECT 
                                    posts.*,
                                    users.Full_names,
                                    users.Avatars,
                                    AVG(scores.Scores) as Scores,
                                    COUNT(scores.Scores) as Voters
                                    FROM posts
                                    INNER JOIN  users
                                    ON posts.Authurs_id = users.Ids
                                    INNER JOIN scores
                                    ON posts.Ids = scores.Posts_id
                                    GROUP BY scores.Posts_id
                                    " . $sort . " " . $direction);
        $get_posts->execute();
        $posts = $get_posts->fetchAll(PDO::FETCH_ASSOC);
        if ($posts) {


            return $posts;
        } else {
            exit("No posts could be found.");
        }
    } else if ($all !== "*" && $all !== NULL) {
        var_dump("not *");
        if (isset($_SESSION['new-post'])) {
            $_SESSION['new-post']['error_msgs'][] = "Forbidden argument send. Try again.";
        } else if (isset($_SESSION['posts'])) {
            var_dump("Posts session added");
            exit("Forbidden argument send. Try again.");
        }
        die();
    }

    $post_id = filter_var($post_id, FILTER_SANITIZE_NUMBER_INT);
    $post_data = [];

    $get_post = $db->prepare("SELECT posts.*,
    users.Full_names,
    users.Avatars,
    AVG(scores.Scores) as Scores,
    COUNT(scores.Scores) as Voters
    FROM posts
    INNER JOIN  users
    ON posts.Authurs_id = users.Ids
    INNER JOIN scores
    ON posts.Ids = scores.Posts_id WHERE posts.Ids = :id
    ORDER BY Published DESC");
    $query_data = ['id' => $post_id];
    $get_post->execute($query_data);
    $posts = $get_post->fetchALL(PDO::FETCH_ASSOC);
    if ($posts) {
        foreach ($posts as $post) {
            $post_data[] = $post;
        }
        // var_dump($post_data);
        return $post_data[0];
    } else {
        exit("Couldn't find any matching posts");
    }
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
        header("Location: ../posts/posts.php?post=" . $post_id . "&visited=true");
        die();
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
    }
}

// ----------------------------------------------------------------



// ----------------- [ Voting ] ---------------------------------- 

function vote($db, int $post_id, int $user, int $score, string $update)
{
    var_dump("Adding score!");

    if ($update === "false") {
        $add_score = $db->prepare("INSERT INTO scores (Posts_id, Users_id, Scores) VALUES (:post, :user, :score)");
    } else {
        $add_score = $db->prepare("UPDATE scores SET Scores = :score WHERE Posts_id = :post AND Users_id = :user");
    }
    $post_data = ['post' => $post_id, 'user' => $user, 'score' => $score];
    try {
        $add_score->execute($post_data);
        header("Location: ../posts/posts.php?post=" . $post_id);
        die();
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
    }
}

// ----------------------------------------------------------------




// ----------------- [ Check if voted ] ------------------ 

function check_voted($db, int $post_id, string $user): bool
{
    $get_user_votes = $db->prepare("SELECT Scores FROM scores WHERE Posts_id = :post AND Users_id = :user");
    $request_data = ['post' => $post_id, 'user' => $user];
    $get_user_votes->execute($request_data);
    $results = $get_user_votes->fetchAll(PDO::FETCH_ASSOC);
    if ($results) {
        return true;
    } else {
        return false;
    }
}

// ----------------------------------------------------------------




// ----------------- [ DELETE POST ] ------------------------------ 

function delete_post($db, string $post_id, string $comments = null)
{
    $delete_post = $db->prepare("DELETE FROM posts WHERE Ids = :post_id");
    $delete_settings = ['post_id' => $post_id];
    try {
        $delete_post->execute($delete_settings);

        $delete_post_scores = $db->prepare("DELETE FROM scores WHERE Posts_id = :post_id");
        try {
            $delete_post_scores->execute($delete_settings);

            try {
                $delete_post_scores->execute($delete_settings);

                $delete_post_comments = $db->prepare("DELETE FROM comments WHERE Posts_id = :post_id");

                try {

                    $delete_post_comments->execute($delete_settings);
                    header("Location: ../posts/posts.php");
                } catch (\PDOException $e) {
                    throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
                }
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
            }
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
        }
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
    }
}


// --------------------------------------------------------------------



// ----------------- [ Comment management] ---------------------------- 

function manage_comment($db, array $comment_data, string $task)
{
    $post = $comment_data['post_id'];

    switch ($task) {

        case "Add":
            var_dump("Adding!");
            $user = $comment_data['user'];
            $comment = $comment_data['comment_txt'];
            $add_comment = $db->prepare("INSERT INTO comments (Posts_id, Users_id, Messages, Published) VALUES (:post_id, :user, :msg, :published)");
            $comment_settings = ['post_id' => $post, 'user' => $user, 'msg' => $comment, 'published' => date('Y-m-d, H:i')];

            try {
                $add_comment->execute($comment_settings);

                header("Location: ../posts/posts.php?post=" . $post);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
            }



            break;

        case "Edit":
            var_dump("Editing");
            $comment_id = $comment_data['comment_id'];
            $comment = $comment_data['comment'];
            $edit_comments = $db->prepare("UPDATE comments SET Messages = :msg WHERE Ids = :comment_id AND Posts_id = :post_id");

            $comment_settings = ['msg' => $comment, 'comment_id' => $comment_id, 'post_id' => $post];

            try {
                $edit_comments->execute($comment_settings);
                header("Location: ../posts/posts.php?post=" . $post);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
            }


            break;

        case "Delete":
            var_dump("DELETING!");
            $comment_id = $comment_data['comment_id'];

            $delete_comment = $db->prepare("DELETE FROM comments WHERE Ids = :comment AND Posts_id = :post");
            $comment_settings = ['comment' => $comment_id, 'post' => $post];

            try {
                $delete_comment->execute($comment_settings);
                unset($_COOKIE['iBLyq7APeDV2']);
                header("Location: ../posts/posts.php?post=" . $post);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
            }
            break;

        case "View":

            $get_comment = $db->prepare("SELECT comments.*, users.Full_names, users.Avatars FROM comments INNER JOIN users ON comments.Users_id = users.Ids WHERE Posts_id = :post_id ORDER BY Published DESC");

            $comment_settings = ['post_id' => $post];

            try {

                $get_comment->execute($comment_settings);
                $comments = $get_comment->fetchAll(PDO::FETCH_ASSOC);
                return $comments;
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
            }
            break;
        default:
            die("Unkown function");
    }
}

// --------------------------------------------------------------------