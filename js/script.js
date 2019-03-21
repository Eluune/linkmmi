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
});
