const order_by_date = document.querySelector("button.date_btn");
const order_by_user = document.querySelector("button.user_btn");
const order_by_score = document.querySelector("button.score_btn");

if (!url.includes("order=")) {
  sessionStorage.setItem("none filtered", url);
}
order_by_date.addEventListener("click", function () {
  if (!url.includes("Published&direction=DESC")) {
    console.log("date click Descnd");
    post_filter(sessionStorage.getItem("none filtered"), "Published", "DESC");
  } else {
    console.log("date click Ascending");
    post_filter(sessionStorage.getItem("none filtered"), "Published", "ASC");
  }
});

order_by_user.addEventListener("click", function () {
  if (!url.includes("names&direction=DESC")) {
    console.log("user click Descnd");
    post_filter(sessionStorage.getItem("none filtered"), "Full_names", "DESC");
  } else {
    console.log("User click Ascending");
    post_filter(sessionStorage.getItem("none filtered"), "Full_names", "ASC");
  }
});

order_by_score.addEventListener("click", function () {
  if (!url.includes("Score&direction=DESC")) {
    console.log("score click Descnd");
    post_filter(sessionStorage.getItem("none filtered"), "Score", "DESC");
  } else {
    console.log("Score click Ascending");
    post_filter(sessionStorage.getItem("none filtered"), "Score", "ASC");
  }
});
