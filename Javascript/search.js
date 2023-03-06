"use strict";

const searchicon = document.querySelector("span");
let searchinput = document.querySelector("#search");

searchicon.addEventListener("click", expand);


function expand()
{
    searchinput.classList.toggle("active-searchbar");
}

