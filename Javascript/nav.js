"use strict";

let nav = document.querySelector("nav");
let main = document.querySelector("main");


nav.addEventListener("mouseenter", function(e){
    e.target.style.left = "-250px";
});

nav.addEventListener("mouseout", function(e){
    e.target.style.left = "0";
});


