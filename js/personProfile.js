let deleteP = document.getElementById("personDeleteButton");
if (deleteP != null) deleteP.addEventListener('click', deletePersonFunction);

let deleteC = document.getElementById("deleteButton");
if (deleteC != null) deleteC.addEventListener('click', deleteCollaboratorFunction);

let deleteS = document.getElementById("shelterDeleteButton");
if (deleteS != null) deleteS.addEventListener('click', deleteShelterFunction);

let announcement = document.getElementById("announcementInfo");
if (announcement != null) announcement.addEventListener('click', redirectAnnouncements);

let proposal = document.getElementById("proposalInfo");
if (proposal != null) proposal.addEventListener('click', redirectProposal);


function deletePersonFunction(event) {
  let actions = event.target.closest('#changeInfo')
  let link1 = actions.dataset.link1
  let link2 = actions.dataset.link2

  genericDeleteFunction(link1, link2)
}

function deleteCollaboratorFunction(event) {
  let actions = event.target.closest('#collaborator')
  let link1 = actions.dataset.link1
  let link2 = actions.dataset.link2

  genericDeleteFunction(link1, link2)
}

function deleteShelterFunction(event) {
  let actions = event.target.closest('#changeInfo')
  let link1 = actions.dataset.link1
  let link2 = actions.dataset.link2

  genericDeleteFunction(link1, link2)
}

function genericDeleteFunction(link1, link2) {
  let r = confirm("Are you sure you want to delete it?")
  if (r == true) {
    window.location.href = link1
  } else window.location.href = link2
}

function redirectAnnouncements(event) {
  let actions = event.target.closest('.announcementInfo')
  window.location.href = actions.dataset.link
}

function redirectProposal(event) {
  let actions = event.target.closest('.proposalInfo')
  window.location.href = actions.dataset.link
}