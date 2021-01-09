let cancel_btns = document.querySelectorAll("button.cancel");

cancel_btns.forEach((cancel_btn) => {
  cancel_btn.addEventListener("click", () => {
    window.location.href = "user.php";
  });
});
