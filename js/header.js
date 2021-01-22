const vw = window.innerWidth;
if (vw > 760) {
    let bar = document.querySelector("#bar");
    document.querySelector("#bar-1").style.display = "none";
    bar.style = "background-color:transparent";
    bar.style.position = "fixed";
    document.querySelectorAll(".bar-menu-item").forEach(item => {
        item.style = "color:white";
    })


    window.addEventListener("scroll", function (event) {

        var scroll_y = this.scrollY;
        if (scroll_y > 100) {
            document.querySelectorAll(".bar-menu-item").forEach(item => {
                item.style = "color:#144E75";
            })
            document.querySelectorAll(".bar-menu-item").forEach(item => {
                item.addEventListener('mouseover', event => {
                    item.style = "color:white";
                })
                item.addEventListener('mouseout', event => {
                    item.style = "color:#144E75"
                })
            })
            bar.style.top = "0";
            bar.style = "background-color:white";
        }
        if (scroll_y <= 100) {
            document.querySelectorAll(".bar-menu-item").forEach(item => {
                item.style = "color:white";
            })
            bar.style = "background-color:transparent";
            document.querySelectorAll(".bar-menu-item").forEach(item => {
                item.addEventListener('mouseover', event => {
                    item.style = "color:white";
                })
                item.addEventListener('mouseout', event => {
                    item.style = "color:white";
                })
            })
        }

    });
};