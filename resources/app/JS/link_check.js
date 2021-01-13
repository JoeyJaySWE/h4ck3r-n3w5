new_post_safty(url);
const title = document.querySelector("#title");
const lnk = document.querySelector("#lnk");
const submit = document.querySelector("button[type='submit']");

console.log("Hej");
lnk.addEventListener("focusout", function () {
  console.log("lnk: " + sessionStorage.getItem("lnk"));
  if (sessionStorage.getItem("lnk") !== lnk.value) {
    if (url.includes("?new_lnk")) {
      console.log("inlcluded");
      url = url.split("?")[0];
      window.location.replace(url);
      console.log("new link: " + newurl);
    }
    console.log("New link!");
    console.log("input changed");
    console.log("text content: " + lnk.value);
    sessionStorage.setItem("position", window.scrollY);
    sessionStorage.setItem("lnk", lnk.value);

    submit.click();
  }

  console.log(submit);
});
