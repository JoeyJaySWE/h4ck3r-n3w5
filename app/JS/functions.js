let cancel_btns = document.querySelectorAll("button.cancel");

cancel_btns.forEach((cancel_btn) => {
  cancel_btn.addEventListener("click", () => {
    window.location.href = "user.php";
  });
});

const url = window.location.href;
const title_field = document.querySelector("#title");
const lnk_field = document.querySelector("#lnk");
const errors = document.querySelector("p.error");

if (url.includes("#post_form")) {
  let oldPos = sessionStorage.getItem("position");
  console.log("stored: " + oldPos);
  window.scrollTo(0, oldPos);

  if (errors.textContent.length < 15) {
    title_field.focus();
  } else {
    console.log("error text is: " + errors.textContent.length);
    lnk_field.focus();
  }
}
