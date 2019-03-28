$(document).ready(function()
{
  $(".popupErreur, body").click(function()
  {
    $(".popupErreur").hide("drop", {direction: "up"}, 500);
  });

  $(".popupErreur").hide("drop", {direction: "up"}, 0, function()
  {
    $(".popupErreur").show("drop", {direction: "up"}, 500);
  });

  $(".comments").click(function()
  {
    var number = $(this).attr("data-number");

    if( $("#comments-" + number).css("display") == "none" )
    {
      $(".section-comments").slideUp(800);
      $("#comments-" + number).slideDown(800);
    }
    else
    {
      $(".section-comments").slideUp(800);
    }
  });

  let files = document.getElementById('file');
    let logo = document.querySelector('.inputfile + label');

    setInterval(function() {
      if(files.files.length != 0) {
        logo.style.background = "rgba(98, 204, 207, 1)";
      }
    }, 2000);
});
