let slideIndex = 1;
let z = document.getElementsByClassName("slideshow");

for (i = 0; i < z.length; i++) {
  z[i].setAttribute("data-currentslide", 1);
  showDivs(z[i].getAttribute("data-currentslide"), i);
}

function plusDivs(n, j) {
  slideIndex = parseInt(z[j].getAttribute("data-currentslide")[0]);
  showDivs(slideIndex += n, j);
}

function currentDiv(n, j) {
  showDivs(slideIndex = n, j);
}

function showDivs(n, j) {
  let i;
  let z = document.getElementsByClassName("slideshow")[j];
  let x = z.getElementsByClassName("slideshow-content");

  if (n > x.length) {
    slideIndex = 1
  }
  if (n < 1) {
    slideIndex = x.length;
  }

  z.setAttribute("data-currentslide", slideIndex);

  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }

  if (x.length > 0)
    x[slideIndex - 1].style.display = "block";
}