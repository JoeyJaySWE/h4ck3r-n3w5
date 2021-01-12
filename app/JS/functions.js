let cancel_btns = document.querySelectorAll("button.cancel");

cancel_btns.forEach((cancel_btn) => {
  cancel_btn.addEventListener("click", () => {
    window.location.href = "user.php";
  });
});

let url = window.location.href;
// cause we triggered the event as we were about to leave the field, we need to send it back to resume it.
function new_post_safty(url) {
  const title_field = document.querySelector("#title");
  const lnk_field = document.querySelector("#lnk");
  const errors = document.querySelector("p.error");
  console.log("bfore if statment");
  if (url.includes("?new_lnk") || sessionStorage.getItem("position") !== null) {
    let oldPos = sessionStorage.getItem("position");
    console.log("stored: " + oldPos);
    window.scrollTo(0, oldPos);

    if (url.includes("true")) {
      title_field.focus();
    } else {
      lnk_field.focus();
      let end = lnk_field.value.length;
      let selection = window.getSelection();
      selection.selectionStart = selection.selectionEnd = end;
      console.log(selection);
    }
  } else {
    console.log("Still empty");
  }
  console.log("psot if statments");
}

function post_filter(url, order, direction = "DESC") {
  if (url.includes(".php?")) {
    window.location.replace(
      url + "&order=" + order + "&direction=" + direction
    );
  } else {
    window.location.replace(
      url + "?order=" + order + "&direction=" + direction
    );
  }
}

if (document.querySelector("button.edit_btn")) {
  const edit_btn = document.querySelector("button.edit_btn");
  edit_btn.addEventListener("click", function () {
    window.location.href = url + "&action=edit";
  });

  //I never add edit without Delete
  const delete_btn = document.querySelector("button.delete");
  delete_btn.addEventListener("click", function () {
    const warned = window.confirm("Are you sure you want to delete this?");
    if (warned === true) {
      console.log("Delete");
      window.location.replace(url + "&iBLyq7APeDV2=ht_4ev!7oEAhvq9U!c@UU9-u*m");
    } else {
      console.log("Keep");
    }
  });
}
