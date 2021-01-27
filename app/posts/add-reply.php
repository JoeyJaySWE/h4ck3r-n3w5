<?php

declare(strict_types=1);

require "../../views/functions.php";


if (isset($_POST['reply'])) {
    $post_id = $_GET['id'];
    $message = filter_var($_POST['reply'], FILTER_SANITIZE_STRING);
    $comment_id = $_GET['comment-id'];
    $user_id = $_GET['user-id'];
    $published = date('Y-m-d, H:i');

    $statement = db()->prepare("INSERT INTO replies (post_id, user_id, comment_id, messages, published) VALUES (:post_id, :user_id, :comment_id, :messages, :published)");
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
    $statement->bindParam(':messages', $message, PDO::PARAM_STR);
    $statement->bindParam(':published', $published, PDO::PARAM_STR);
    $statement->execute();

    header("Location: /app/posts/posts.php?post=" . $post_id);
}

if (isset($_POST['delete-reply'])) {
    $post_id = $_GET['id'];
    $reply_id = $_GET['reply-id'];
    $user_id = $_GET['user-id'];

    $statement = db()->prepare('DELETE FROM replies WHERE post_id = :post_id AND user_id = :user_id AND id = :reply_id');
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':reply_id', $reply_id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: /app/posts/posts.php?post=" . $post_id);
}
