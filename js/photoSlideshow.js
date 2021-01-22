let slideIndex = 1;
showSlides(slideIndex);

let previous = document.getElementById("prev");
if (previous != null) previous.addEventListener('click', minusSlides);

let next = document.getElementById("next");
if (next != null) next.addEventListener('click', minusSlides);

function plusSlides() {
  showSlides(slideIndex += 1);
}

function minusSlides() {
  showSlides(slideIndex -= 1);
}

function currentSlides(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("slideshow-content");

  if (n > slides.length) {
    slideIndex = 1
  }
  if (n < 1) {
    slideIndex = slides.length;
  }

  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }

  if (slides.length > 0)
    slides[slideIndex - 1].style.display = "block";
}