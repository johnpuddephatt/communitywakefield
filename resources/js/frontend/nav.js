const navToggleElement = document.querySelector(".navbar--toggler");
const navMenuElement = document.querySelector(".navbar--navs");

if (navToggleElement) {
  navToggleElement.addEventListener("click", () => {
    navMenuElement.classList.toggle("active");
  });
}
