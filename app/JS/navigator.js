const tab = document.title;
const burger = document.querySelector(".menu_burger");
if (burger) {
  console.log("Use burger for navigation");
  const burger_item = document.querySelectorAll(".burger_menu>li");

  switch (tab) {
    case "H4ck3r N3w5":
      burger_item[0].style.borderBottom = "2px solid";
      break;
    case "Terms and Conditions":
      console.log(burger_item[1].children[0].textContent);
      if (burger_item[2].children[0].textContent === "Terms & Conditions") {
        burger_item[2].style.borderBottom = "2px solid";
      } else {
        // burger_item[2].children[1].children[].style.borderBottom = "2px solid";
        burger_item[2].children[0].setAttribute("open", null);
        burger_item[2].children[0].children[2].style.borderBottom = "2px solid";
      }
      break;
    //   case "User Page":
    //     menue_item[2].style.borderBottom = "2px solid";
    //     break;
    case "Login Page":
      burger_item[1].style.borderBottom = "2px solid";
      break;
    case "Register new H4ck3r":
      burger_item[3].style.borderBottom = "2px solid";
      break;
  }
} else {
  const menue_item = document.querySelectorAll(".navbar>nav>li");

  console.log("JS found");

  switch (tab) {
    case "H4ck3r N3w5":
      menue_item[0].style.borderBottom = "2px solid";
      break;
    case "Terms and Conditions":
      menue_item[1].style.borderBottom = "2px solid";
      break;
    case "User Page":
      menue_item[2].style.borderBottom = "2px solid";
      break;
    case "Login Page":
      menue_item[2].style.borderBottom = "2px solid";
      break;
    case "Register new H4ck3r":
      menue_item[3].style.borderBottom = "2px solid";
      break;
  }
}
