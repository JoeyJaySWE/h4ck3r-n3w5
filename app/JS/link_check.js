const link = document.querySelector("#lnk");
const submit = document.querySelector("button[type='submit']");

console.log("Hej");
link.oninput = function () {
  console.log("input changed");
  sessionStorage.setItem("position", window.scrollY);

  submit.click();
};
