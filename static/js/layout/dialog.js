function dialog(action) {
    const dialogBox = document.querySelector(".dialogBox-container");
    const lineAnim = document.querySelector(".line-anim");

    if (action === "open") {
        dialogBox.classList.add("active");

        lineAnim.classList.remove("animate");
        void lineAnim.offsetWidth;
        lineAnim.classList.add("animate");

        setTimeout(() => {
            dialogBox.classList.remove("active");
        }, 5000);
    } else if (action === "close") {
        dialogBox.classList.remove("active");
        lineAnim.classList.remove("animate");
    }
}