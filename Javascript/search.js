"use strict";

const searchicon = document.querySelector("span");
let searchinput = document.querySelector("#search");
const recentContent = document.querySelector('.recentcontent');
const categories = document.querySelectorAll('.recentcontentscroll p');

searchicon.addEventListener("click", expand);


function expand()
{
    searchinput.classList.toggle("active-searchbar");
}


searchinput.addEventListener('input', () => {
    const searchText = search.value.toLowerCase();
    const recentContentItems = recentContent.querySelectorAll('p');

    // Filtre contenu récent
    recentContentItems.forEach(item => {
        const itemText = item.textContent.toLowerCase();
        if (itemText.includes(searchText)) {
            item.style.display = 'inherit';
        } else {
            item.style.display = 'none';
        }
    });

    // Filtre les différents catégories
    categories.forEach(category => {
        const categoryText = category.textContent.toLowerCase();
        if (categoryText.includes(searchText)) {
            category.style.display = 'inherit';
        } else {
            category.style.display = 'none';
        }
    });
});
