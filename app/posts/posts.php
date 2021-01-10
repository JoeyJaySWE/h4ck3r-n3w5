<?php
session_start();

// if (!isset($_SESSION['user'])) {
//     header("location: login.php");
// }

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


// checks if we are watching the flow or a specific post
if (isset($_GET['post'])) {

    require "../../views/functions.php";

    $post_id = (int)$_GET['post'];
    $post_data = get_post(db(), $post_id);

    $title = $post_data['Titles'];
}


// $_SESSION['user'] = "";

// checks if it's the Author who signed in,
// if not, we add 1 to the view coutner.
if ($_SESSION['user'] !== $post_data['Full_name'] && !isset($_GET['visited'])) {
    die("still not set");
    add_visit(db(), $post_id);
}
//     // die("set");
// }



require "../../views/header.php";

// -----------------------------------------------------------------
?>

<main>
    <?php if (isset($post_data)) : ?>
        <section class="post_head">

            <figure>
                <img class="avatar" src="<?= $post_data['Avatar']; ?>" alt="<?= $post_data['Full_name']; ?>">
                <strong><?= $post_data['Full_name']; ?></strong>
            </figure>
            <h1><?= $post_data['Titles']; ?></h1>
        </section>
        <p><?= $post_data['Descriptions']; ?> <br><a href="<?= $post_data['Links']; ?>"><?= $post_data['Links']; ?></a></p>
        <time class="published"><?= $post_data['Links_visits'] ?> views, <?= $post_data['Published']; ?></time>

    <?php else : ?>

    <?php endif; ?>
</main>


<?php

// ----------------- [ Scripts ] ------------------ 

$scripts = [
    '/app/JS/navigator.js',
    '/app/JS/functions.js',
];

// ----------------------------------------------------------------



require "../../views/footer.php";

?>