function dislikeAnimal(petID) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open('post', "../actions/action_unfav_pet.php?" + encodeForAjax({
        id: petID
    }), true);
    xmlhttp.onload = function () {
        document.getElementById("fav-undone-" + petID).style.display = "inline";
        document.getElementById("fav-done-" + petID).style.display = "none";
    }
    xmlhttp.send();
}

function likeAnimal(petID) {

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open('GET', "../actions/action_fav_pet.php?" + encodeForAjax({
        id: petID
    }), true);
    xmlhttp.onload = function () {
        document.querySelector(".fav-background").style.background = "linear-gradient(-120deg,#FFB17A,#ff964b)";
        document.getElementById("fav-undone-" + petID).style.display = "none";
        document.getElementById("fav-done-" + petID).style.display = "inline";
    }
    xmlhttp.send();

}

function cssLikeAnimal() {

    let array;
    let id;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open('GET', "../actions/action_get_fav_pet.php", true);
    xmlhttp.send();
    xmlhttp.onload = function () {
        try{
            array = (JSON.parse(this.responseText));
        }
        catch (e){
            return;
        }
        for (let i = 0; i < array.length; i++) {
            id = array[i].petID;
            document.getElementById("fav-done-" + id).style.display = "inline";
            document.getElementById("fav-undone-" + id).style.display = "none";
        }
    }


}

cssLikeAnimal();
let id = document.querySelector(".userspets");
id = id['id'].substring(9, id.length);

let adoption = document.getElementById('adoption-proposals');
let given = document.getElementById('pets-given');
let fav = document.getElementById('favorite-pets')
let liked = document.querySelectorAll(".fav-done");
let unliked = document.querySelectorAll(".fav-undone");

let animalCards = document.querySelectorAll(".animal-card");
if (id == 0) {
    given.style.display = "none";
    fav.style.display = "none";
} else if (id == 1) {
    adoption.style.display = "none";
    fav.style.display = "none";
    for (let i = 0; i < liked.length; i++) {
        liked[i].addEventListener('click', event => {
            dislikeAnimal(liked[i]['id'].substring(9, liked[i]['id'].length));
        })
    }
    for (let j = 0; j < unliked.length; j++) {
        unliked[j].addEventListener('click', event => {
            unliked[j]['id'].substring(11, unliked[j]['id'].length)
            likeAnimal(unliked[j]['id'].substring(11, unliked[j]['id'].length));
        })
    }
} else {
    adoption.style.display = "none";
    given.style.display = "none";
    for (let i = 0; i < liked.length; i++) {
        liked[i].addEventListener('click', event => {
            dislikeAnimal(liked[i]['id'].substring(9, liked[i]['id'].length));
        })
    }
    for (let j = 0; j < unliked.length; j++) {
        unliked[j].addEventListener('click', event => {
            unliked[j]['id'].substring(11, unliked[j]['id'].length)
            likeAnimal(unliked[j]['id'].substring(11, unliked[j]['id'].length));
        })
    }
}