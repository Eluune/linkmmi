$(document).ready(function()
{
  $("#btn-inscription").click(function()
  {
    var prenom = $("#prenom").val();
    var nom = $("#nom").val();
    var mail = $("#mail").val();
    var password = $("#password").val();
    var password2 = $("#password2").val();

    if(password == password2 && mail != "" && nom != "" && prenom != "")
    {
      $.ajax
      ({
         url: "php/inscription.php",
         type: "post",
         data: {
           prenomUser: prenom,
           nomUser: nom,
           mailUser: mail,
           passwordUser: password
         },
         success: function (response) {
           if(response == "inscrit")
           {
             // connexion
             $(".popupInscript").fadeOut("fast");
           }
           else
           {
             alert("erreur de connexion, mettre un message");
           }
         },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrow);
         }
      });
    }
  });
});
