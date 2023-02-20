"use strict";

let musique = document.querySelectorAll(".musique-scroll");


musique.forEach((e)=>{

    e.addEventListener("wheel", (event) =>{
        event.preventDefault();
        e.scrollLeft += event.deltaY;
    })
})

