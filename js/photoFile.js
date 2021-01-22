let photosInput = document.getElementById("petPhotos");
if (photosInput != null) photosInput.addEventListener("change", loader);

let petphotoInput = document.getElementById("petPhoto");
if (petphotoInput != null) petphotoInput.addEventListener("change", loader);

let profilephotoInput = document.getElementById("profilePhoto");
if (profilephotoInput != null) profilephotoInput.addEventListener("change", loader);

let postphotoInput = document.getElementById("postPhoto");
if (postphotoInput != null) postphotoInput.addEventListener("change", loader);

function loader(e) {

    if(e.target.files[0].size > 8000000){
        alert("File is too big!");
        this.value = "Upload a Photo";
    }


    let file = e.target.files;
    let show = "";
    for (let f = 0; f < file.length; f++) {
        show += file[f].name;
        if (f != file.length - 1)
            show += ",";
    }

    let output = document.getElementById("selector");

    output.innerHTML = show;
    output.classList.add("active");
};