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
