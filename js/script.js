$(document).ready(function()
{
<<<<<<< HEAD
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
=======


  /*
  * Connexion
  *   - récupère les données saisies et compare avec les données issues de la bdd
  *
  * Données utilisées
  */

  // $("#connexion-submit").click(function()
  // {
  //   var login = $("#connexion-login").val();
  //   var mdp = $("#connexion-password").val();
  //
  //   $.ajax
  //   ({
  //      url: "php/connexion.php",
  //      type: "post",
  //      data: { mailUser: login, passwordUser: mdp },
  //      success: function (response)
  //      {
  //        switch(reponse)
  //        {
  //          case "connecte":
  //
  //          break;
  //
  //          case "mdp":
  //          break;
  //
  //          case "email":
  //          break;
  //        }
  //      },
  //      error: function(jqXHR, textStatus, errorThrown) {
  //         console.log(textStatus, errorThrow);
  //      }
  //   });
  // });


>>>>>>> cb318ae98977d952d6afc73fcca55f1c9dab63da
});
