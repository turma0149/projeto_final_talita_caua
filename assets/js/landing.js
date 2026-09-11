const botao = document.querySelector(".menu-toggle");
const menu = document.querySelector("nav");

botao.addEventListener("click", () => {
  menu.classList.toggle("ativo");
});
