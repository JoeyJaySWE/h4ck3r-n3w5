// Moas kod

//Visa reply-formulär on click!
const replyForms = document.querySelectorAll(".hidden_reply_form");
const replyBtns = document.querySelectorAll(".reply_btn");

replyBtns.forEach((replyBtn) => {
  replyBtn.addEventListener("click", (e) => {
    const commentId = e.currentTarget.dataset.commentid;

    replyForms.forEach((form) => {
      if (form.dataset.commentid == commentId) {
        form.classList.toggle("reply_form");
      }
    });
  });
});

// Hämta antal upvotes på kommentarerna

const upvoteCommentBtns = document.querySelectorAll(".upvote_comment_btn");
const numberOfUpvotesSpan = document.querySelectorAll(
  ".number-of-comment-upvotes"
);

console.log(upvoteCommentBtns);

upvoteCommentBtns.forEach((upvoteBtn) => {
  upvoteBtn.addEventListener("click", (e) => {
    const commentId = e.currentTarget.dataset.commentid;
    const userId = e.currentTarget.dataset.userid;
    fetch(`comment-upvote.php?comment-id=${commentId}&user-id=${userId}'`, {
      credentials: "include",
      method: "POST",
    })
      .then(function (res) {
        return res.json();
      })
      .then((upvote) => {
        numberOfUpvotesSpan.forEach((item) => {
          if (item.dataset.commentid == commentId) {
            if (upvote == 1) {
              item.textContent = `${upvote} vote`;
            } else {
              item.textContent = `${upvote} votes`;
            }
          }
        });
      });
  });
});
