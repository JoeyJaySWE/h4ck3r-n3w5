const replyForms = document.querySelectorAll(".hidden_reply_form");
console.log(replyForms);
const replyBtns = document.querySelectorAll(".reply_btn");
console.log(replyBtns);

replyBtns.forEach((replyBtn) => {
  replyBtn.addEventListener("click", (e) => {
    console.log(replyBtn);

    const commentId = e.currentTarget.dataset.commentid;
    let boxOpen = false;

    replyForms.forEach((form) => {
      if (form.dataset.commentid == commentId && boxOpen == false) {
        form.classList.toggle("reply_form");
        let boxOpen = true;
      }
    });
  });
});
