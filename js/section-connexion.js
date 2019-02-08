$(document).ready(function() {
  $(".comments").click(function() {

    var number = $(this).attr("data-number");

    if( $("#comments-" + number).css("display") == "none" ) {

      $(".section-comments").slideUp(800);
      $("#comments-" + number).slideDown(800);

    }else{

      $(".section-comments").slideUp(800);

    }

  });
});

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