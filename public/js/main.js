





function openModal(popupId){
    const subjectPopup = document.getElementById(popupId);
    const spaceWork = document.getElementById('space-work');
    subjectPopup.classList.remove('hidden');
    spaceWork.classList.add('overflow-hidden')
}

function closeModal(popupId){
    const subjectPopup = document.getElementById(popupId);
    const spaceWork = document.getElementById('space-work');
    subjectPopup.classList.add('hidden');
    spaceWork.classList.remove('overflow-hidden')
}