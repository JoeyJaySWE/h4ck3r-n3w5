if (document.querySelector("button.edit_btn")) {
  const edit_btn = document.querySelector("button.edit_btn");
  edit_btn.addEventListener("click", function () {
    window.location.href = url + "&action=edit_post";
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
