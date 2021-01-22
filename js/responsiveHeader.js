let menu = document.querySelector(".hamburger-bar-content");

document.getElementById("hamburger").addEventListener("click", event => {
    display();
})

function display() {
    if (menu.style.display != "flex")
        menu.style.display = "flex";
    else {
        menu.style.display = "none";
    }

}