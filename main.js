const login = document.getElementById("login-form");
const hidden = document.getElementById("hidden-heading");
const iframe = document.getElementById("iframe-container");
const video = document.getElementById("video");
const chat = document.getElementById("live-chat");
document.getElementById("form").addEventListener("submit", function (e) {
  e.preventDefault();
  seralize(this);
  const data = seralize(this);
  this.reset();
  fetch(`authentication.php?${data}`, {
    method: "GET",
    headers: new Headers(),
    mode: "cors",
    cache: "default",
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (json) {
      if (json.Status === "incorrect") {
        hidden.classList.add("error");
        hidden.innerHTML = `Either your Surname or Membership Card Number is Incorrect. Make sure you have not added any spaces, or that you are not known by any other surname. For help logging in please contact xxxxxxx`;
      } else if (json.Status === "signed in computer") {
        hidden.innerHTML = "Already Signed in";
        hidden.classList.add("error");
        window.removeEventListener(
          "beforeunload",
          async function () {
            endSession();
          },
          true
        );
      } else if (json.Status === "signed in elsewhere") {
        hidden.innerHTML = "Currently logged in elsewhere";
        hidden.classList.add("error");
        window.removeEventListener(
          "beforeunload",
          async function () {
            endSession();
          },
          true
        );
      } else {
        window.addEventListener(
          "beforeunload",
          async function () {
            endSession();
          },
          true
        );
        hidden.classList.add("success");
        login.style.display = "none";
        iframe.style.display = "flex";
        video.querySelector("iframe").src = json.Video;
        video.style.display = "block";
        if (json.Status === "both") {
          chat.querySelector("iframe").src = json.Chat;
          chat.style.display = "block";
          hidden.innerHTML =
            "Login Successful, access to video and chat granted";
        } else {
          hidden.innerHTML = "Login Successful, access to video granted";
        }
        video.scrollIntoView();
      }
    })
    .catch(function (error) {
      console.error("ERROR:", error);
    });
});
const seralize = (form) => {
  let requestArray = [];
  form.querySelectorAll("[name]").forEach((elem) => {
    requestArray.push(elem.name + "=" + elem.value);
  });
  if (requestArray.length > 0) return requestArray.join("&");
  else return false;
};

async function endSession() {
  const response = await fetch("session.php");
  const array = await response.text();
  console.log("User login detected", array);
  if (array) {
    hidden.innerHTML = "Login Detected!";
  }
}
