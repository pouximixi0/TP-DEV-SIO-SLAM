const images = document.querySelectorAll(".heroImages img");
let courante = 0;

if (images.length > 1) {
    setInterval(function () {
        images[courante].classList.remove("visible");
        courante = courante + 1;
        if (courante >= images.length) {
            courante = 0;
        }
        images[courante].classList.add("visible");
    }, 4000);
}
