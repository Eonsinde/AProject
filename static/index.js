let navToggler = document.querySelector("#m-nav-toggler");
let closeBtn = document.querySelector("#close-btn");
let mobileNav = document.querySelector("#mobile-nav");

navToggler.addEventListener("click", () => {
    document.body.style.overflowY = "hidden";
    mobileNav.classList.remove("translate-x-full");
    mobileNav.classList.add("translate-x-0");
});

closeBtn.addEventListener("click", () => {
    document.body.style.overflowY = "auto";
    mobileNav.classList.remove("translate-x-0");
    mobileNav.classList.add("translate-x-full");
});
