let linkButtons = document.querySelectorAll("#petLink")
for (let i = 0; i < linkButtons.length; i++)
    linkButtons[i].addEventListener('click', function (event) {
        let petInfo = event.target.closest('#petInfo')
        window.location.href = petInfo.dataset.link
    })

let answerButtons = document.querySelectorAll("#answerbutton")
for (let i = 0; i < answerButtons.length; i++)
    answerButtons[i].addEventListener('click', addAnswer)

let editAnswerButtons = document.querySelectorAll("#editAnswer")
for (let i = 0; i < editAnswerButtons.length; i++)
    editAnswerButtons[i].addEventListener('click', editAnswerArea)

let acceptButtons = document.querySelectorAll("#accept")
for (let i = 0; i < acceptButtons.length; i++)
    acceptButtons[i].addEventListener('click', acceptButtonFunction)

let rejectButtons = document.querySelectorAll("#reject")
for (let i = 0; i < rejectButtons.length; i++)
    rejectButtons[i].addEventListener('click', rejectButtonFunction)

let rejectedButtons = document.querySelectorAll("#rejected")
for (let i = 0; i < rejectedButtons.length; i++)
    rejectedButtons[i].addEventListener('click', rejectedButtonFunction)

let cancelButtons = document.querySelectorAll("#cancelbtn")
for (let i = 0; i < cancelButtons.length; i++)
    cancelButtons[i].addEventListener('click', deletePopup)

let deleteButtons = document.querySelectorAll("#deleteQuestion")
for (let i = 0; i < deleteButtons.length; i++)
    deleteButtons[i].addEventListener('click', deleteQuestionPopup)

function deleteQuestionPopup(event) {
    event.preventDefault()

    let question = event.target.closest('.question')
    let questionID = question.dataset.questionid

    let element = document.createElement('div')
    element.className = "popup"
    element.dataset.link = "../actions/action_delete_question.php?id=" + questionID
    element.innerHTML = '<form class="popup-content">' +
        '<div class="container">' +
        '<h3>Delete Question</h3>' +
        '<p>Are you sure you want to delete this question?</p>' +
        '<div class="clearfix">' +
        '<button id="cancelbtn">Cancel</button>' +
        '<button id="confirmbtn">Confirm</button>' +
        '</div>' +
        '</div>' +
        '</form>'
    document.querySelector(`[data-questionid="${questionID}"]`).appendChild(element)
    document.getElementById('cancelbtn').addEventListener('click', deletePopup)
    document.getElementById('confirmbtn').addEventListener('click', deleteQuestion)

}

function deleteQuestion(event) {
    let question = event.target.closest('.popup')
    deletePopup()
    window.location.href = question.dataset.link
}


function addAnswer(event) {
    event.preventDefault()

    let question = event.target.closest('.question')
    let questionID = question.dataset.questionid

    let answerText = question.querySelector("textarea").value

    if(!testInput(answerText)){
        let element = document.querySelector(`[data-questionid="${questionID}"] #answerSection p`)
        let parent = element.parentNode 
        if(element != null) element.remove()
        
        let error = document.createElement("p")
        error.setAttribute('id', 'errorMessage')
        error.innerHTML = "Invalid input: maximum of 100 characters and no invalid symbols"
        error.style = "color: red; font-size:10px; margin-top:-10px";
        parent.appendChild(error)

    }
    else{
        let d = document.getElementById('errorMessage')
        if (d != null) {
            let a = d.parentNode
            a.removeChild(d)
            let message = document.createElement('p')
            message.innerHTML = '(Maximum characters: 100)'
            message.setAttribute('id', 'font')
            message.style = "margin-top:-10px"
            a.appendChild(message)

        }

        let xmlhttp = new XMLHttpRequest()
        xmlhttp.open('GET', "../actions/action_answer_question.php?" + encodeForAjax({
            id: questionID,
            answer: answerText
        }), true)


        xmlhttp.onload = function () {
            let answerID
            try {
                answerID = (JSON.parse(this.responseText))
            } catch (e) {
                return;
            }

            addAnswerToPage(answerText, answerID, questionID)
        }

        xmlhttp.send()

    }


    
}

function addAnswerToPage(answerText, answerID, questionID) {
    document.querySelector(`[data-questionid="${questionID}"] #answerSection`).remove()

    let answerT = document.createElement('p')
    answerT.id = "answerText"
    answerT.innerHTML = answerText

    let answerDiv = document.createElement('div')
    answerDiv.className = "buttons"
    answerDiv.dataset.answerid = answerID
    answerDiv.dataset.answer = answerText
    answerDiv.innerHTML = '<button id="editAnswer">Edit Answer</button>' +
        '<button id="deleteQuestion">Delete</button>'

    document.querySelector(`[data-questionid="${questionID}"]`).appendChild(answerT)
    document.querySelector(`[data-questionid="${questionID}"]`).appendChild(answerDiv)
    document.querySelector(`[data-questionid="${questionID}"] #editAnswer`).addEventListener('click', editAnswerArea)
    document.querySelector(`[data-questionid="${questionID}"] #deleteQuestion`).addEventListener('click', deleteQuestionPopup)
}

function editAnswerArea(event) {
    event.preventDefault()
    let answer = event.target.closest('.buttons')
    let answerID = answer.dataset.answerid
    let answerText = answer.dataset.answer

    let question = event.target.closest('.question')
    let questionID = question.dataset.questionid

    document.querySelector(`[data-questionid="${questionID}"] #answerText`).remove()
    document.querySelector(`[data-questionid="${questionID}"] .buttons`).remove()

    let answerSection = document.createElement('form')
    answerSection.method = 'form'
    answerSection.id = 'answerSection'
    answerSection.dataset.questionid = questionID
    answerSection.dataset.answerid = answerID
    answerSection.dataset.answer = answerText
    answerSection.innerHTML = '​<textarea id="answerArea" name="answerArea" rows="4" cols="40" maxlength="100">' + answerText + '</textarea>' +
        '<p id="answer">(Maximum characters: 100)</p>' +
        '<div class="buttons">' +
        '<button id="answerbutton">Edit</button>' +
        '<button id="cancelbutton">Cancel</button>' +
        '</div>'

    document.querySelector(`[data-questionid="${questionID}"]`).appendChild(answerSection)
    document.querySelector(`[data-questionid="${questionID}"] #answerbutton`).addEventListener('click', editAnswer)
    document.querySelector(`[data-questionid="${questionID}"] #cancelbutton`).addEventListener('click', cancelEdit)
}

function cancelEdit(event) {
    event.preventDefault()

    let form = event.target.closest('form')
    let answerText = form.dataset.answer
    let answerID = form.dataset.answerid
    let questionID = form.dataset.questionid

    addAnswerToPage(answerText, answerID, questionID)
}

function editAnswer(event) {
    event.preventDefault()

    let question = event.target.closest('#answerSection')
    let answerID = question.dataset.answerid
    let questionID = question.dataset.questionid

    let answerText = question.querySelector("textarea").value
    let xmlhttp = new XMLHttpRequest()
    xmlhttp.open('GET', "../actions/action_edit_answer.php?" + encodeForAjax({
        id: answerID,
        answer: answerText
    }), true)

    xmlhttp.onload = addAnswerToPage(answerText, answerID, questionID)
    xmlhttp.send()
}


function rejectButtonFunction(event) {
    let proposal = event.target.closest('.proposal')
    let id = proposal.dataset.proposalid

    let element = document.createElement('div')
    element.className = "popup"
    element.dataset.id = id
    element.innerHTML = '<form class="popup-content">' +
        '<div class="container">' +
        '<h3>Reject proposal</h3>' +
        '<p>Are you sure you want to reject this proposal?</p>' +
        '<div class="clearfix">' +
        '<button id="cancelbtn">Cancel</button>' +
        '<button id="confirmbtn">Confirm</button>' +
        '</div>' +
        '</div>' +
        '</form>'


    document.querySelector(`[data-proposalid="${id}"]`).appendChild(element)
    document.getElementById('cancelbtn').addEventListener('click', deletePopup)
    document.getElementById('confirmbtn').addEventListener('click', rejectProposal)
}

function rejectProposal(event) {
    event.preventDefault()

    let proposal = event.target.closest('.popup')
    let proposalID = proposal.dataset.id

    let xmlhttp = new XMLHttpRequest()
    xmlhttp.open('GET', "../actions/action_update_confirmed_proposal.php?" + encodeForAjax({
        id: proposalID,
        confirmed: 2
    }), true)

    deletePopup()

    xmlhttp.onload = updateConfirmed(2, proposalID)
    xmlhttp.send()
}

function acceptButtonFunction(event) {
    let proposal = event.target.closest('.proposal')
    let id = proposal.dataset.proposalid

    let element = document.createElement('div')
    element.className = "popup"
    element.dataset.id = id
    element.innerHTML = '<form class="popup-content">' +
        '<div class="container">' +
        '<h3>Accept proposal</h3>' +
        '<p>Are you sure you want to accept this proposal? You can only accept one and all others will be rejected!</p>' +
        '<div class="clearfix">' +
        '<button id="cancelbtn">Cancel</button>' +
        '<button id="confirmbtn">Confirm</button>' +
        '</div>' +
        '</div>' +
        '</form>'


    document.querySelector(`[data-proposalid="${id}"]`).appendChild(element)
    document.getElementById('cancelbtn').addEventListener('click', deletePopup)
    document.getElementById('confirmbtn').addEventListener('click', acceptProposal)
}

function acceptProposal(event) {
    event.preventDefault()

    let proposal = event.target.closest('.popup')
    let proposalID = proposal.dataset.id

    let xmlhttp = new XMLHttpRequest()
    xmlhttp.open('GET', "../actions/action_update_confirmed_proposal.php?" + encodeForAjax({
        id: proposalID,
        confirmed: 0
    }), true)

    deletePopup()

    xmlhttp.onload = function(){
        updateConfirmed(0, proposalID)
        let rm = document.getElementById("reject")
        let ac = document.getElementById("accept")
        let p = rm.parentNode
        p.removeChild(rm)
        p.removeChild(ac)

        let rejected = document.createElement("p")
        rejected.setAttribute('id', 'rejectedP')
        rejected.innerHTML = "Rejected"
        p.appendChild(rejected)

    }
    xmlhttp.send()
}

function rejectedButtonFunction(event) {
    let proposal = event.target.closest('.proposal')
    let id = proposal.dataset.proposalid

    let element = document.createElement('div')
    element.className = "popup"
    element.dataset.id = id
    element.innerHTML = '<form class="popup-content">' +
        '<div class="container">' +
        '<h3>Delete Answer</h3>' +
        '<p>Are you sure you want to remove your answer to this proposal?</p>' +
        '<div class="clearfix">' +
        '<button id="cancelbtn">Cancel</button>' +
        '<button id="confirmbtn">Confirm</button>' +
        '</div>' +
        '</div>' +
        '</form>'

    document.querySelector(`[data-proposalid="${id}"]`).appendChild(element)
    document.getElementById('cancelbtn').addEventListener('click', deletePopup)
    document.getElementById('confirmbtn').addEventListener('click', rejectedProposal)
}

function rejectedProposal(event) {
    event.preventDefault()

    let proposal = event.target.closest('.popup')
    let proposalID = proposal.dataset.id

    let xmlhttp = new XMLHttpRequest()
    xmlhttp.open('GET', "../actions/action_update_confirmed_proposal.php?" + encodeForAjax({
        id: proposalID,
        confirmed: 1
    }), true)

    deletePopup();

    xmlhttp.onload = updateConfirmed(1, proposalID)
    xmlhttp.send()
}

function updateConfirmed(confirmed, proposalID) {
    let buttonsSection = document.querySelector(`[data-proposalid="${proposalID}"] .buttons`)

    if (confirmed == 2) {
        buttonsSection.innerHTML = '<button id="rejected">Rejected</button>'
        let button = document.querySelector(`[data-proposalid="${proposalID}"] #rejected`)
        button.addEventListener('click', rejectedButtonFunction)
    } else if (confirmed == 0) {
        buttonsSection.innerHTML = '<p id="accepted">Accepted</p>'
    } else if (confirmed == 1) {
        buttonsSection.innerHTML = '<button id="reject">Reject</button> <button id="accept">Accept</button>'

        let buttonReject = document.querySelector(`[data-proposalid="${proposalID}"] #reject`)
        buttonReject.addEventListener('click', rejectButtonFunction)
        let buttonAccept = document.querySelector(`[data-proposalid="${proposalID}"] #accept`)
        buttonAccept.addEventListener('click', acceptButtonFunction)
    }
}

function deletePopup() {
    let element = document.getElementsByClassName('popup')
    element[0].remove()
}


function testInput(input){
    if((/^[^\w" "]/.test(input)) === true) return false;
    else if (/(?=[^\w \-\,\;\!\"\(\)\'.?: ])/.test(input)) return false
    else if(/(?=[\-\,\;\!\"\(\)\'.?:]{2})/.test(input)) return false
    else if(input.length >=100 || input.length == 0) return false
    return true
  }