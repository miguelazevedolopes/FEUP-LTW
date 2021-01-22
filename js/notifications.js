let questionNotifications = document.querySelectorAll("#questionNotification")
for (let i = 0; i < questionNotifications.length; i++)
questionNotifications[i].addEventListener('click', goToPetProfile)

let proposalNotifications = document.querySelectorAll("#proposalNotification")
for (let i = 0; i < proposalNotifications.length; i++)
proposalNotifications[i].addEventListener('click', goToProposals)

function goToPetProfile(event) {
    let notification = event.target.closest('#notification')
    window.location.href = notification.dataset.link
}

function goToProposals() {
    window.location.href = "../pages/userspets.php?id=0"
}