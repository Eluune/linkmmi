$(document).ready(function()
{
<<<<<<< HEAD
  // $.ajax
  // ({
  //    url: "php/connexion.php",
  //    type: "post",
  //    data: {  },
  //    success: function (response) {
  //
  //    },
  //    error: function(jqXHR, textStatus, errorThrown) {
  //       console.log(textStatus, errorThrow);
  //    }
  // });
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
=======
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
>>>>>>> 16d50077bde76b46d3eadb58f8bf7cf45ddd1147
});
