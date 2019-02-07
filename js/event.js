document.querySelector(".contentPopup").addEventListener("click", function(event) {
    event.stopPropagation();
});
document.querySelector(".popupInscript").addEventListener("click", closePopUp);


document.querySelector("#inscript").addEventListener("click", function() {
    document.querySelector(".popupInscript").className += " active";
});

document.querySelector(".closeInscript").addEventListener("click", closePopUp);

function closePopUp() {
    document.querySelector(".popupInscript").classList.remove("active");
}