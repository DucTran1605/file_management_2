import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

const openModalBtn = document.getElementById("openModalBtn");
const closeModalBtn = document.getElementById("closeModalBtn");
const modalBackdrop = document.getElementById("modalBackdrop");

openModalBtn.addEventListener("click", () => {
    modalBackdrop.classList.remove("hidden");
});

closeModalBtn.addEventListener("click", () => {
    modalBackdrop.classList.add("hidden");
});
