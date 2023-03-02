"use strict";

let inputcheck = document.querySelector("input[type=checkbox]");
let iconcheck = document.querySelector(".checked")

iconcheck.addEventListener("click", check);

function check()
{
    if(inputcheck.checked)
    {
        iconcheck.innerHTML = '<i class="fa-regular fa-square"></i>'
    }
    else
    {
        iconcheck.innerHTML = '<i class="fa-regular fa-square-check"></i>'
    }
}
  