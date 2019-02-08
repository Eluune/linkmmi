$(document).ready(function()
{
  current = -1;
  nbresults = 0;

  $("#recherche").keyup(function(e)
  {
    if(e.keyCode != 38 && e.keyCode != 40)
    {
      current = -1;
      var recherche = $(this).val();

      $.ajax
      ({
         url: "php/recherche.php",
         type: "post",
         data: { recherche: recherche },
         success: function (response)
         {
           $(".resultat").remove();
           response = response.split(" ");
           nbresults = response.length -1;

           for(var i = 0 ; i < response.length-1 ; i++)
           {
             if(current == i)
             {
               $(".resultats").append("<div class='resultat active' id=r" + i + ">" + response[i] + "</div>");
             }
             else
             {
               $(".resultats").append("<div class='resultat' id=r" + i + ">" + response[i] + "</div>");
             }
           }
         },
         error: function(jqXHR, textStatus, errorThrown) { console.log(textStatus, errorThrow); }
       });
    }
  });

  $(document).keydown(function(e)
  {
    if(e.keyCode == 40)
    { // Down
      if(current < nbresults - 1)
      {
        remove(current);
        current++;
        active(current);
      }
    }
    else if (e.keyCode == 38)
    { // Up
      if(current > -1)
      {
        remove(current);
        current--;
        active(current);
      }
    }
    else if (e.keyCode == 13)
    { // Enter
      var contenu = $("#r"+current).text();
      $("#recherche").val(contenu);
    }
  });


  $( ".resultats" ).on( "click", ".resultat", function() {
    var text = $(this).text();
    $("#recherche").val(text);
  });
});

function active(i) { $("#r"+i).addClass("active"); }
function remove(i) { $("#r"+i).removeClass("active"); }
