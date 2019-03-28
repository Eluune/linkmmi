// Gére les likes sur le topics
$(".like").click(function()
{
  $(this).toggleClass('like-active');
  if($(this).hasClass('like-active'))
  {
    $(this).addClass('like-anim');
  }
  else
  {
    $(this).removeClass('like-anim');
  }
  var idUser = $('#data-user').attr("data-number");
  var idPost = $(this).parent().attr("data-number");
  $.ajax
  ({
     url: "php/like.php",
     type: "post",
     data: { idUser: idUser,
             idPost: idPost
            },
     success: function (response)
     {
       $(".nb-like-"+idPost).text(response);
     },
     error: function(jqXHR, textStatus, errorThrown)
     {
        console.log(textStatus, errorThrow);
     }
  });
});

// Gére les commentaires sur les topics
$('input[type="text"]').keypress(function(e)
{
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
         success: function (response)
         {
           var atname = response.split("#");
           nbComment++;
           $('.nb-comments-'+idPost).text(nbComment);
           $("#comments-"+idPost+" .commentaire-users").append('<a href="profil.php?user='+atname[1]+'">@'+atname[0]+'</a><p>'+commentaire+'</p>');
         },
         error: function(jqXHR, textStatus, errorThrown)
         {
            console.log(textStatus, errorThrow);
         }
      });
    }
  }
});
