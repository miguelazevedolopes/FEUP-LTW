let question = document.getElementById("questionbutton")
if (question != null) question.addEventListener('click', addQuestion)

let deletes = document.getElementById("deleteButton")
if (deletes != null) deletes.addEventListener('click', deleteFunction)

let prev = document.getElementById("deleteButton")
if (prev != null) prev.addEventListener('click', deleteFunction)

let proposal = document.getElementById("makeProposalButton")
if (proposal != null) proposal.addEventListener('click', makeProposalPopup)

let goToProposal = document.getElementById("goToProposals")
if (goToProposal != null) goToProposal.addEventListener('click', redirectProposal)

let goToRehome = document.getElementById("goToRehome")
if (goToRehome != null) goToRehome.addEventListener('click', function () {
  window.location.href = "../pages/rehome-intro.php"
})

function addQuestion(event) {
  event.preventDefault();
  let pet = event.target.closest('#questionCard')
  let petID = pet.dataset.id
  let questionText = pet.querySelector("textarea").value;

  if (!testQuestion(questionText)) {
    let p = document.getElementById("font");
    let a = p.parentNode;
    p.parentNode.removeChild(p);
    let error = document.createElement('p')
    error.setAttribute('id', 'errorMessage')
    error.innerHTML = "Invalid input: from 1-100 characters with no special characters, did you forget the question mark :)";
    error.style = "color: red; font-size:10px; margin-top:-10px";

    a.appendChild(error);
  } else {
    let d = document.getElementById('errorMessage')
    if (d != null) {
      let a = d.parentNode
      a.removeChild(d)
      let message = document.createElement('p')
      message.innerHTML = '(Maximum characters: 100)'
      message.setAttribute('id', 'font')
      a.appendChild(message)

    }

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open('GET', "../actions/action_ask_question.php?" + encodeForAjax({
      id: petID,
      question: questionText
    }), true);
    xmlhttp.onload = addQuestionToPage(event)
    xmlhttp.send();
  }
}

function makeProposalPopup(event) {
  event.preventDefault()

  let proposalButton = document.getElementById('makeProposalButton')
  let petID = proposalButton.dataset.id

  let element = document.createElement('div')
  element.className = "createProposal"
  element.dataset.id = petID
  element.innerHTML = '<form class="popup-content" method="get">' +
    '<div class="container">' +
    '<h1>Make a proposal</h1>' +
    '<textarea id="proposalText" rows="6" cols="40" placeholder="Write you adoption proposal here" maxlength="300"></textarea>' +
    '<p id="answer">(Maximum characters: 300)</p>' +
    '<div class="clearfix">' +
    '<button id="submitbtn">Submit</button><br>' +
    '<button id="cancelbtn">Cancel</button>' +
    '</div>' +
    '</div>' +
    '</form>'


  document.getElementById("rehomeCard").appendChild(element)
  document.getElementById('cancelbtn').addEventListener('click', deleteProposalPopup)
  document.getElementById('submitbtn').addEventListener('click', makeProposal)

}

function makeProposal(event) {
  event.preventDefault()

  let createProposal = document.querySelector('.createProposal')
  let petID = createProposal.dataset.id

  let proposalPopup = document.getElementById('proposalText')
  let proposalText = proposalPopup.value

  deleteProposalPopup(event)

  let xmlhttp = new XMLHttpRequest()
  xmlhttp.open('GET', "../actions/action_add_proposal.php?" + encodeForAjax({
    id: petID,
    text: proposalText
  }), true)

  xmlhttp.onload = updateProposalButton()
  xmlhttp.send()

}

function deleteProposalPopup(event) {
  event.preventDefault()
  let element = document.getElementsByClassName('createProposal')
  element[0].remove()
}

function updateProposalButton() {

  let proposalButton = document.getElementById('makeProposalButton')
  proposalButton.remove()

  let element = document.createElement('button')
  element.id = 'goToProposals'
  element.innerHTML = "See the proposal you have made for this pet"
  element.addEventListener('click', redirectProposal)

  document.getElementById('rehomeCard').appendChild(element)
}

function addQuestionToPage(event) {

  alert("Your question was submitted!")

  let pet = event.target.closest('#questionCard')
  pet.querySelector("textarea").value = ""
}

function deleteFunction(event) {
  let actions = event.target.closest('#petActions')
  let link1 = actions.dataset.link1
  let link2 = actions.dataset.link2
  let r = confirm("Are you sure you want to delete it?")
  if (r == true) {
    window.location.replace(link1);
  } else window.location.replace(link2);

}

function testQuestion(question) {
  if (/^[^A-Za-z" "]/.test(question) === true) return false;
  if (!question.match(/\w\?$|\s\?$/)) return false;
  else if (question.match(/(?=[^\w-,;!"()'.?: ])/)) return false;
  else if (question.match(/(?=[\-\,\;\!\"\(\)\'.?:]{2})/)) return false;
  else if (question.length >= 100) return false;
  else return true;
}

function redirectProposal() {
  window.location.href = "../pages/userspets.php?id=0";
}