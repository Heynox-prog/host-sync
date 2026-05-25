function toggleMenu() {
    const toggler = document.querySelector(".sort-articles__toggler");
    const menu = document.querySelector(".sort-articles__type");

    if (toggler && menu) {
        toggler.addEventListener("click", () => {
            menu.classList.toggle("active");
        });
    }
}

function changeText() {
    const toggler = document.querySelector(".sort-articles__toggler");
    const choices = document.querySelectorAll(".sort-articles__type_choice");
    const menu = document.querySelector(".sort-articles__type");

    choices.forEach((choice) => {
        choice.addEventListener("click", () => {
            toggler.textContent = choice.textContent;
            
            choices.forEach((btn) => {
                btn.classList.remove("active");
            })

            choice.classList.add("active");
            menu.classList.remove("active");
        })
    })
}

changeText();

function changeLocation() {
    const choices = document.querySelectorAll(".sort-articles__type_choice");

    choices.forEach((btn) => {
        btn.addEventListener("click", () => {
            const sortType = btn.getAttribute("data-sort");
            const label = btn.textContent.trim();
            localStorage.setItem("lastSortLabel", label);
            window.location.href = `?sort=${sortType}`;
        });
    });
}

window.addEventListener("DOMContentLoaded", () => {
    const label = localStorage.getItem("lastSortLabel");
    const toggler = document.querySelector(".sort-articles__toggler");

    if (label && toggler) {
        toggler.textContent = label;
    }

    toggleMenu();
    changeLocation();
});