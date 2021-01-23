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




if (!isset($_SESSION['posts'])) {
    $_SESSION['posts'] = [];
}
unset($_SESSION['new-post']);

require "../../views/functions.php";
$title = "N3w5 Flow";

if (isset($_GET)) {
    $_GET = form_sanitizer($_GET);
}

if (
    isset($_GET['comment'], $_GET['commentor'], $_GET['action'])
    && $_GET['post'] === $_COOKIE['post_id']
    && $_GET['comment'] === $_COOKIE['comment_id']
) {
    $comment_request = [];
    if ($_GET['action'] === "delete_comment" && (isset($_COOKIE['iBLyq7APeDV2'])) && $_COOKIE['iBLyq7APeDV2'] === "ht_4ev!7oEAhvq9U!c@UU9-u*m") {
        $comment_request['comment_id'] = $_COOKIE['comment_id'];
        $comment_request['post_id'] = $_COOKIE['post_id'];
        manage_comment(db(), $comment_request, "Delete");
    } else if ($_GET['action'] === "edit_comment") {
        $edit = true;
    }
}


// checks if we are watching the flow or a specific post
if (isset($_GET['post'])) {


    $post_id = (int)$_GET['post'];
    $post_data = get_post(db(), $post_id);
    $title =  $post_data['Titles'];





    // checks if it's the Author who signed in,
    // if not, we add 1 to the view coutner.
    if ($_SESSION['user'] !== $post_data['Full_names'] && !isset($_GET['visited'])) {
        // die("still not set");

        add_visit(db(), $post_id);
    } else if ($_SESSION['user'] !== $post_data['Full_names'] && isset($_GET['visited'])) {
        $not_authur = true;
    }
}



require "../../views/header.php";

// -----------------------------------------------------------------
?>

<main class="post">
    <?php



    // ---------------- [ Specific Post ] -----------------------------



    if (isset($post_data)) :
        if ($_SESSION['user'] === $post_data['Full_names'] && isset($_GET['action']) && $_GET['action'] === "edit_post") :
            var_dump("User post edit");
    ?>


            <form class="post_card" action="../databases/db.php" method="post">
                <input type="hidden" name="task" value="edit_post">
                <input type="hidden" name="post_id" value="<?= $post_data['Ids'] ?>">
                <section class="post_head">

                    <figure>
                        <img class="avatar" src="<?= $post_data['Avatars']; ?>" alt="<?= $post_data['Full_names']; ?>">
                        <figcaption><?= $post_data['Full_names']; ?></figcaption>
                    </figure>
                    <input require type="text" name="title" value="<?= $post_data['Titles']; ?>" />
                </section>
                <textarea require name="description"><?= $post_data['Descriptions']; ?> </textarea>

                <button type="submit" name="submit">Update!</button><button class="cancel" formnovalidate formaction="posts.php?post=<?= $post_data['Ids']; ?>">Cancel</button>

                <p class="error">
                    <?php if (isset($_SESSION['error_msgs'])) {
                        echo $_SESSION['error_msgs'];
                    } ?>
                </p>
            </form>
            </article>
        <?php

        else :
            unset($_GET['action']);
        endif; //ends the "if user is authur and action = edit_post"
        if (!isset($_GET['action']) /*|| $_GET['action'] !== "edit_comment" || $_GET['action'] !== "delete_comment"*/) : ?>
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
                                if ($post_data['Voters'] === "1") {
                                    echo "Unrated";
                                } else echo $post_data['Scores'] . " (" . $post_data['Voters'] . " votes)"; ?>,</li>
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
                            endif; //ends the "if vote !== true"
                        ?>
                    </form>

            <?php endif; //ends the "if isset($not_authur)"



                    endif; //ends the "if !isset($_GET['action'])"


            ?>
            </article>

            <?php
            if (!isset($not_authur) && !isset($_GET['action'])) :

                // check if delete is triggered
                if (isset($_GET['iBLyq7APeDV2']) && $_GET['iBLyq7APeDV2'] === "ht_4ev!7oEAhvq9U!c@UU9-u*m") {
                    delete_post(db(), $post_data['Ids']);
                } ?>


                <section class="authur_tools">

                    <button class="edit_btn">Edit Post</button>
                    <button class="delete">DELETE POST</button>

                </section>

            <?php
            endif; // ends "if current authur"




            // Comment section
            ?>


            <section class="comments_section">
                <details>
                    <summary>Leave a comment</summary>
                    <form class="comment_form" action="../databases/db.php" method="post">
                        <input type="hidden" name="task" value="add_comment">
                        <input type="hidden" name="user" value="<?= $_SESSION['user_id']; ?>">
                        <input type="hidden" name="post_id" value="<?= $post_data['Ids'] ?>">
                        <textarea requireed maxlength="5000" name="comment_txt"></textarea>
                        <button type="submit" name="submit">Comment!</button>
                    </form>
                </details>
                <?php
                $comment_request = [];
                $comment_request['post_id'] = $post_data['Ids'];
                $comments = manage_comment(db(), $comment_request, "View");
                $replies = manage_reply(db(), $comment_request, "View");
                // die(var_dump($replies));
                foreach ($comments as $comment) :

                    if (isset($edit)) :
                        if ($comment['Ids'] === $_COOKIE['comment_id']) : ?>
                            <form action="../databases/db.php" method="post">
                                <article class="post_card">
                                    <input type="hidden" name="task" value="edit_comment">
                                    <input type="hidden" name="post_id" value="<?= $post_data['Ids']; ?>">
                                    <input type="hidden" name="comment_id" value="<?= $comment['Ids'] ?>">
                                    <textarea required name="comment"><?= $comment['Messages']; ?></textarea>
                                    <section class="comment_tools">
                                        <button type="submit" name="submit" value="submit">Save!</button>
                                        <button class="cancel" formnovalidate formaction="posts.php?post=<?= $post_data['Ids'] ?>">Cancel</button>
                                    </section>
                                </article>
                            </form>

                    <?php endif; //Comment ID
                        continue;
                    endif; //edit
                    ?>

                    <article class=" post_card">
                        <figure>
                            <img class="comment_avatar" src="<?= $comment['Avatars'] ?>" alt="<?= $comment['Full_names']; ?>">
                            <figcaption><?= $comment['Full_names']; ?></figcaption>
                        </figure>
                        <p><?= $comment['Messages']; ?></p>
                        <section class="comment_tools">
                            <?php
                            if ($comment['Users_id'] === $_SESSION['user_id']) : ?>
                                <button data-comment-id="<?= $comment['Ids']; ?>" data-comment-writer="<?= $comment['Users_id'] ?>" data-post-id="<?= $post_data['Ids']; ?>" class="delete">DELETE</button>
                            <?php endif; ?>
                            <button data-commentid="<?= $comment['Ids']; ?>" data-comment-writer="<?= $comment['Users_id'] ?>" data-post-id="<?= $post_data['Ids']; ?>" class="reply_btn">Reply</button>
                            <?php if ($comment['Users_id'] === $_SESSION['user_id']) : ?>
                                <button data-comment-id="<?= $comment['Ids']; ?>" data-comment-writer="<?= $comment['Users_id'] ?>" data-post-id="<?= $post_data['Ids']; ?>" class="edit_btn">Edit</button>
                            <?php endif; ?>
                        </section>
                        <ul class="comment_stats">
                            <li><time>Published <?= $comment['Published']; ?></time></li>
                        </ul>


                        <!-- MOA ADDITIONS !!!!!!!! -->
                        <section class="reply-container">
                            <form action="/app/posts/add-reply.php?id=<?= $post_data['Ids']; ?>&comment-id=<?= $comment['Ids']; ?>&user-id=<?= $_SESSION['user_id']; ?>" method="post" class="hidden_reply_form comment_form" data-commentid="<?= $comment['Ids']; ?>">
                                <div>
                                    <label for="reply">Reply to comment</label>
                                    <textarea requireed maxlength="5000" type="text" name="reply" id="reply"></textarea>
                                </div>
                                <button type="submit">Reply</button>
                            </form>
                            <section class="replies">
                                <?php foreach ($replies as $reply) : ?>
                                    <?php if ($reply['comment_id'] === $comment['Ids']) : ?>
                                        <section class="single-reply">
                                            <figure>
                                                <img class="comment_avatar" src="<?= $reply['Avatars']; ?>" alt="<?= $reply['Full_names']; ?>" />
                                                <figcaption><?= $reply['Full_names']; ?></figcaption>
                                            </figure>
                                            <div class="reply-content">
                                                <p>
                                                    <?= $reply['messages']; ?>
                                                </p>
                                                <p class="reply-published">
                                                    <?= $reply['published']; ?>
                                                </p>
                                            </div>
                                            <?php if ($reply['user_id'] === $_SESSION['user_id']) : ?>
                                                <form action="/app/posts/add-reply.php?id=<?= $post_data['Ids']; ?>&reply-id=<?= $reply['id']; ?>&user-id=<?= $_SESSION['user_id']; ?>" method="post" class="delete-reply-btn">
                                                    <input type="hidden" name="delete-reply" id="delete-reply" />
                                                    <button type="submit" class="delete delete-reply-btn">Delete</button>
                                                </form>
                                            <?php endif; ?>
                                        </section>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </section>
                        </section>
                    </article>

                <?php endforeach; ?>
            </section>


        <?php
    // -------------------------- [ Posts Feed ] ----------------------------



    else : ?>


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
                        <li>Score: <?php if ($post['Voters'] === "1") {
                                        echo "Unrated";
                                    } else echo $post['Scores'] ?>,</li>
                        <li><time>Published <?= $post['Published']; ?></time></li>
                    </ul>
                </article>


            <?php endforeach;


            // -------------------------------------------------------------------------
            ?>
        <?php endif; ?>
</main>


<?php

// ----------------- [ Scripts ] ----------------------------------

if (!isset($_GET['post'])) {

    $scripts = [
        '/app/JS/navigator.js',
        '/app/JS/functions.js',
        '/app/JS/post_filters.js'
    ];
} else {
    if (!isset($not_authur)) {
        $scripts = [

            '/app/JS/functions.js',
            '/app/JS/edit_comment.js',
            '/app/JS/edit_post.js',
            '/app/JS/navigator.js',
            '/app/JS/reply_comment.js'
        ];
    } else {

        $scripts = [
            '/app/JS/navigator.js',
            '/app/JS/functions.js',
            '/app/JS/edit_comment.js',
            '/app/JS/reply_comment.js'
        ];
    }
}

// ----------------------------------------------------------------



require "../../views/footer.php";

?>
