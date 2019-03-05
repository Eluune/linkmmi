$(document).ready(function()
{
  $.ajax
  ({
     url: "php/connexion.php",
     type: "post",
     data: {  },
     success: function (response) {

     },
     error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrow);
     }
  });
});
