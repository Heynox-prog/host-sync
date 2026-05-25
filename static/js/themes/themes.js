function toggleTheme() {
  const body = document.body;
  const currentTheme = body.getAttribute("data-theme");
  const newTheme = currentTheme === "dark" ? "light" : "dark";

  body.setAttribute("data-theme", newTheme);

  document.cookie = `theme=${newTheme}; path=/; max-age=31536000; SameSite=Lax${
    location.protocol === "https:" ? "; Secure" : ""
  }`;

  updateIcons(newTheme);
}

function updateIcons(theme) {
  const sunIcons = document.querySelectorAll(".fa-sun");
  const moonIcons = document.querySelectorAll(".fa-moon");

  if (theme === "light") {
    sunIcons.forEach(icon => {
      icon.style.display = "inline-block";
    });
    moonIcons.forEach(icon => {
      icon.style.display = "none";
    });
  } else {
    sunIcons.forEach(icon => {
      icon.style.display = "none";
    });
    moonIcons.forEach(icon => {
      icon.style.display = "inline-block";
    });
  }
}

function changeHeaderIcon() {
  const headerImg = document.querySelector(".header--img");
  const currentTheme = document.body.getAttribute("data-theme") || "light";

  if (currentTheme === "dark") {
    headerImg.src = "/static/images/logo/header/dark-logo_h.png";
  } else {
    headerImg.src = "/static/images/logo/header/light-logo_h.png";
  }
}

window.addEventListener("DOMContentLoaded", () => {
  const currentTheme = document.body.getAttribute("data-theme") || "light";
  updateIcons(currentTheme);
  changeHeaderIcon();
});