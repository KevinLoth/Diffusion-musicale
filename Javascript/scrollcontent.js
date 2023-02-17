"use strict";

let musique = document.querySelectorAll(".musique-scroll");
let isDragging = false;
let startPosition = 0;
let currentTranslate = 0;

musique.forEach((e)=>{
    musique.addEventListener("mousedown", (e) => {
    isDragging = true;
    startPosition = e.clientX - musique.offsetLeft;
    currentTranslate = parseInt(window.getComputedStyle(musique).getPropertyValue("transform").split(",")[4]);
    musique.style.cursor = "grabbing";
});

musique.addEventListener("mousemove", (e) => {
if (isDragging) {
    const newPosition = e.clientX - musiques.offsetLeft;
    const diffPosition = newPosition - startPosition;
    musique.style.transform = `translateX(${currentTranslate + diffPosition}px)`;
}
});

musique.addEventListener("mouseup", () => {
    isDragging = false;
    musique.style.cursor = "grab";
});
})

// !TODO Régler problème JS