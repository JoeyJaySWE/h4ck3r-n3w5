if (document.querySelectorAll(".comment_tools>.edit_btn")) {
  const edit_btns = document.querySelectorAll(".comment_tools>.edit_btn");
  console.log(edit_btns);
  console.log("Found edit buttons!");

  edit_btns.forEach((edit_btn) => {
    edit_btn.addEventListener("click", function (e) {
      console.log("click");
      const comment_id = e.target.dataset.commentId;
      const comment_authur = e.target.dataset.commentWriter;
      const post_id = e.target.dataset.postId;
      console.log("Commenter: " + comment_authur);
      document.cookie = `comment_athur=` + comment_authur;
      document.cookie = `comment_id=` + comment_id;
      document.cookie = `post_id=` + post_id;
      document.cookie = `scroll=` + window.scrollY;
      localStorage.setItem("scroll", window.scrollY);
      window.location.replace(
        url +
          "&comment=" +
          comment_id +
          "&commentor=" +
          comment_authur +
          "&action=edit_comment"
      );
    });
  });
}
if (document.querySelectorAll(".comment_tools>.delete")) {
  const delete_btns = document.querySelectorAll(".comment_tools>.delete");
  delete_btns.forEach((delete_btn) => {
    delete_btn.addEventListener("click", function (e) {
      const comment_id = e.target.dataset.commentId;
      const comment_authur = e.target.dataset.commentWriter;
      const post_id = e.target.dataset.postId;
      console.log("Commenter: " + comment_authur);

      if (window.confirm("Are you sure you want to delete this comment?")) {
        document.cookie = `comment_athur=` + comment_authur;
        document.cookie = `comment_id=` + comment_id;
        document.cookie = `post_id=` + post_id;
        window.location.replace(
          url +
            "&comment=" +
            comment_id +
            "&commentor=" +
            comment_authur +
            "&action=delete_comment"
        );
      }
    });
  });
}
