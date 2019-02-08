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
  $(".popupInscript").fadeIn("fast");
});

document.querySelector(".closeInscript").addEventListener("click", closePopUp);

function closePopUp() {
  $(".popupInscript").fadeOut("fast");
}




document.querySelector(".imgPopup").addEventListener("click", function(event) {
  event.stopPropagation();
});
document.querySelector(".popupImg-container").addEventListener("click", closePopUpImg);


$(".image-content img").click(function() {
  var srcImg = $(this).attr("src");
  $(".imgPopup img").attr("src",srcImg);
  $(".popupImg-container").fadeIn("fast");
});

document.querySelector(".closeImg").addEventListener("click", closePopUpImg);

function closePopUpImg() {
  $(".popupImg-container").fadeOut("fast");
}