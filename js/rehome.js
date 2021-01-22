const vw = window.innerWidth;

if (vw <= 450) {
    let filterButton = document.getElementById("filter-show");
    let searchButton = document.getElementById("search-show");
    let searchShow = document.querySelector(".search-container")
    let filterShow = document.getElementById("filter-type")
    filterButton.addEventListener("click", event => {
        if (filterShow.style.display != "block") {
            filterShow.style.display = "block";
        } else
            filterShow.style.display = "none";
    })
    searchButton.addEventListener("click", event => {
        if (searchShow.style.display != "block") {
            searchShow.style.display = "block";
        } else
            searchShow.style.display = "none";
    })
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

let filteredCheckBoxes = document.getElementById("filters")

if(filteredCheckBoxes){
    filteredCheckBoxes.addEventListener('input',filter) 
}
    
function filter(){
    let doc = document.getElementById("noAnimals")
    if(doc != null){
        doc.parentNode.removeChild(doc);
    }

    let filters = {}

    let checked = filteredCheckBoxes.querySelectorAll('input[type=checkbox]:checked')

    for(let i = 0; i <  checked.length; i++){
        filters[checked[i].name] = filters[checked[i].name] || []
        filters[checked[i].name].push(checked[i].value)
    }

    let animals = document.querySelectorAll(".animal-card");
    let filteredResults = [...animals]
    
    Object.values(filters).forEach((values)=>{
        filteredResults = filteredResults.filter(animalCard=>{
            let checked = false
            values.forEach(val =>{
                if(animalCard.dataset.info.includes(val)){
                    checked = true
                    return true
                }
            })
            return checked
        })
        
    })

    animals.forEach((element)=>{
        element.style.display = "none";
    })

    filteredResults.forEach((element)=>{
        element.style.display = "block";
    })
    
    if(filteredResults.length == 0){
        let d = document.getElementById("display-animals")
        let element = document.createElement("h3")
        element.style = "margin-left: 300px"
        element.innerHTML = "There are no animals corresponding to your filters :("
        element.setAttribute("id", "noAnimals")
        d.appendChild(element)
    }

}



function search(){
    const inputElement = document.querySelector('#searchInput');
    inputElement.addEventListener('keyup', handleEvent);

    function handleEvent() {
        let text = inputElement.value;
        searchDOM(text);
    }

    function searchDOM(text) {
        let valuesToCompare;
        const animalCards = document.querySelectorAll('.animal-card');
        let flag = false;
        if (text == "") {
            animalCards.forEach(element => {
                element.style.display = "block"
            });
        } else {
            animalCards.forEach(element => {
                element.style.display = "none"
            });
            animalCards.forEach(element => {
                if (element['id'].toUpperCase().includes(text.toUpperCase())) {
                    element.style.display = "block";
                    flag = true;
                } else {
                    valuesToCompare = element.getElementsByTagName('h2');
                    for (let i = 0; i < valuesToCompare.length; i++) {
                        if ((valuesToCompare[i].textContent.toUpperCase().includes(text.toUpperCase())) && (text.toUpperCase() !== ("NAME" || "AGE" || "SPECIES" || "SEX" || ":" || "MALE"))) {
                            element.style.display = "block";
                            flag = true;
                        }
                    }
                }
                if (!flag) {
                    element.style.display = "none";
                }


            });
        }
    }
}
cssLikeAnimal();
 let id = document.querySelector(".getFilterID");
 id = id['id'].substring(6,id.length);
 let checkbox = document.querySelectorAll(".filter-1");

 if(id < checkbox.length){
    checkbox[id].checked = true}
 filter();
let kup = document.getElementById("searchInput");
if (kup != null) kup.addEventListener('keyup', search);

let kdown = document.getElementById("searchInput");
if (kdown != null) kdown.addEventListener('keydown', search);

let checkboxes = document.querySelectorAll(".filter-1");
for (let i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', filter);
}

let liked = document.querySelectorAll(".fav-done");
let unliked = document.querySelectorAll(".fav-undone");
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