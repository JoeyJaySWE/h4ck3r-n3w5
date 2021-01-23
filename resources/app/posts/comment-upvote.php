<?php

declare(strict_types=1);

require "../../views/functions.php";

if (isset($_POST)) {
    $commentId = $_GET['comment-id'];
    $user_id = $_GET['user-id'];

    $statement = db()->prepare('SELECT * FROM comments_upvotes WHERE comment_id = :comment_id AND user_id = :user_id');
    $statement->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();
    $commentsUpvote = $statement->fetch();

    if ($commentsUpvote === false) {
        $statement = db()->prepare('INSERT INTO comments_upvotes (comment_id, user_id) VALUES(:comment_id, :user_id)');
        $statement->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        $statement->execute();
    } else {
        $statement = db()->prepare('DELETE FROM comments_upvotes WHERE comment_id = :comment_id AND user_id = :user_id');
        $statement->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        $statement->execute();
    }

    // omvandlar mängden upvotes till json-data som fångas upp i JS.
    $commentUpvotes = countCommentsUpvotes(db(), $commentId);
    echo json_encode($commentUpvotes);
}
