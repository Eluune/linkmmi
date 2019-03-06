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

    $(".like").click(function(){
      $(this).toggleClass('like-active');
      var idUser = $('#data-user').attr("data-number");
      var idPost = $(this).parent().attr("data-number");
      $.ajax
      ({
         url: "php/like.php",
         type: "post",
         data: { idUser: idUser,
                 idPost: idPost
                },
         success: function (response) {
           $(".nb-like-"+idPost).text(response);
         },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrow);
         }
      });
    });

    $('input[type="text"]').keypress(function(e) {
      var code = e.keyCode || e.which;
      var idUser = $('#data-user').attr("data-number");
      var idPost = $(this).parent().attr("data-number");

      if(code === 13){
        var commentaire = document.getElementById("text-commentaire-"+idPost).value.trim();
        var nbComment = parseInt($('.nb-comments-'+idPost).text());
        if(commentaire != ''){
          document.getElementById("text-commentaire-"+idPost).value = '';
          $.ajax
          ({
             url: "php/commentaire.php",
             type: "post",
             data: { ajouter: true,
                     idUser: idUser,
                     idTopic: idPost,
                     contenuCommentaire: commentaire
                    },
             success: function (response) {
               var atname = response.split("#");
               nbComment++;
               console.log(nbComment)
               $('.nb-comments-'+idPost).text(nbComment);
               $("#comments-"+idPost+" .commentaire-users").append('<a href="profil.php?user='+atname[1]+'">@'+atname[0]+'</a><p>'+commentaire+'</p>');
             },
             error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrow);
             }
          });
        }
      }
    });
});
