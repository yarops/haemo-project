document.addEventListener('DOMContentLoaded', function () {
    const scrollBtn = document.querySelector<HTMLElement>("#back-to-top");

    if (scrollBtn === null) return;
    const btnVisibility = () => {
        if (window.scrollY > 400) {
            scrollBtn.style.visibility = "visible";
        } else {
            scrollBtn.style.visibility = "hidden";
        }
    };
    document.addEventListener("scroll", () => {
        btnVisibility();
    });

    scrollBtn.addEventListener("click", (e) => {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
});