window.addEventListener("scroll", () => {
  const nav = document.getElementById("nav");
  if (scrollY > 40) {
    nav.classList.add("scrolling");
  } else {
    nav.classList.remove("scrolling");
  }
});
//addClasslist.add('name')
document.addEventListener("DOMContentLoaded", () => {
  const slider = document.querySelector(".scrollbar");
  const cards = document.querySelectorAll(".review-card");
  let current = 0;
  let timer;

  function goTo(index) {
    current = (index + cards.length) % cards.length;
    slider.scrollTo({ left: slider.clientWidth * current, behavior: "smooth" });
  }

  function startAuto() {
    timer = setInterval(() => goTo(current + 1), 2000);
  }

  slider.addEventListener("scroll", () => {
    clearInterval(timer);
    setTimeout(startAuto, 1500);
  });

  startAuto();
});
