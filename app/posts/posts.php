<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: login.php");
}

// ----------------- [ META DATA ] ------------------

$meta_title = "Creat Post!";
$meta_desc = "This is the heart and soul of H4ck3r N3w5. Here you upload your links and become part of the comunity.";
$meta_img = "../../assets/img/favicon.png";
$meta_card = "summary";
$meta_card_alt = "A newspaper made up of code";

// ----------------------------------------------------------------


// ----------------- [ Style sheets ] ------------------ 
$styles = [
    '../../../assets/css/reset.css',
    '../../../assets/css/defaults.css',
    '../../../assets/css/post.css'
];

// ----------------------------------------------------------------


$title = "Create Post";

if (!isset($_SESSION['posts'])) {
    $_SESSION['posts'] = [];
}
unset($_SESSION['new-post']);

require "../../views/functions.php";
// checks if we are watching the flow or a specific post
if (isset($_GET['post'])) {


    $post_id = (int)$_GET['post'];
    $post_data = get_post(db(), $post_id);

    $title = $post_data['Titles'];





    // checks if it's the Author who signed in,
    // if not, we add 1 to the view coutner.
    if ($_SESSION['user'] !== $post_data['Full_names'] && !isset($_GET['visited'])) {
        // die("still not set");

        add_visit(db(), $post_id);
    } else if ($_SESSION['user'] !== $post_data['Full_names'] && isset($_GET['visited'])) {
        $not_authur = true;
    }
    // die(var_dump($_SESSION));
}



require "../../views/header.php";

// -----------------------------------------------------------------
?>

<main class="post">
    <?php if (isset($post_data)) : ?>
        <article class="post_card">
            <section class="post_head">

                <figure>
                    <img class="avatar" src="<?= $post_data['Avatars']; ?>" alt="<?= $post_data['Full_names']; ?>">
                    <figcaption><?= $post_data['Full_names']; ?></figcaption>
                </figure>
                <h1><?= $post_data['Titles']; ?></h1>
            </section>
            <p><?= $post_data['Descriptions']; ?> <br><a href="<?= $post_data['Links']; ?>"><?= $post_data['Links']; ?></a></p>
            <ul class="post_stats">
                <li><?= $post_data['Links_visits']; ?> views,</li>
                <li>Score: <?php
                            if ($post_data['Scores'] === "1") {
                                echo "Unrated";
                            } else echo $post_data['Scores'] ?>&nbsp;(<?= $post_data['Voters'] ?> votes),</li>
                <li><time>Published <?= $post_data['Published']; ?></time></li>
            </ul> <?php

                    if (isset($not_authur)) :
                        $voted = check_voted(db(), (int)$post_id, $_SESSION['user_id']); ?>
                <form class="vote_form" action="../databases/db.php" method="post">
                    <input type="hidden" name="task" value="vote">
                    <input type="hidden" name="post_id" value="<?= $post_data['Ids']; ?>">
                    <strong>Give your vote!</strong>
                    <select name="score">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <?php if ($voted !== true) : ?>
                        <input type="hidden" name="update" value="false">
                        <button type="submit" name="submit">Vote!</button>
                    <?php else : ?>
                        <input type="hidden" name="update" value="true">
                        <button type="submit" name="submit">Change Vote!</button>
                    <?php
                        endif; ?>
                </form>
            <?php endif;


            ?>
        </article>

    <?php else : ?>


        <ul class="post_filter">
            <li><button class="date_btn">Sort By Date</button></li>
            <li><button class="user_btn">Sort By User</button></li>
            <li><button class="score_btn">Sort By Score</button></li>
        </ul>


        <?php
        if (isset($_GET['order'])) {
            switch ($_GET['order']) {
                case "Published":
                    $order = "Published";
                    break;
                case "Full_names":
                    $order = "Full_names";
                    break;
                case "Score":
                    $order = "Scores";
                    break;
                default:
                    $order = null;
            }

            if (isset($_GET['direction'])) {

                switch ($_GET['direction']) {
                    case "DESC":
                        $direction = "DESC";
                        break;
                    case "ASC":
                        $direction = "ASC";
                        break;
                    default:
                        $direction = "DESC";
                }
            } else {
                $direction = "DESC";
            }
        } else {
            $order = null;
            $direction = null;
        }
        $posts = get_post(db(), 666, "*", $order, $direction);

        foreach ($posts as $post) :
            // echo "<p>";
            // var_dump($post);
            // echo "</p>";
        ?>

            <article class="post_card">
                <figure>
                    <img class="avatar" src="<?= $post['Avatars'] ?>" alt="<?= $post['Full_names']; ?>">
                    <figcaption><?= $post['Full_names']; ?></figcaption>
                </figure>
                <h2><a href="posts.php?post=<?= $post['Ids'] ?>"><?= $post['Titles'] ?></a></h2>
                <ul class="post_stats">
                    <li><?= $post['Links_visits']; ?> views,</li>
                    <li>Score: <?php if ($post['Scores'] === "1") {
                                    echo "Unrated";
                                } else echo $post['Scores'] ?>,</li>
                    <li><time>Published <?= $post['Published']; ?></time></li>
                </ul>
            </article>


        <?php endforeach;

        ?>
    <?php endif; ?>
</main>


<?php

// ----------------- [ Scripts ] ------------------ 

$scripts = [
    '/app/JS/navigator.js',
    '/app/JS/functions.js',
    '/app/JS/post_filters.js'
];

// ----------------------------------------------------------------



require "../../views/footer.php";

?>