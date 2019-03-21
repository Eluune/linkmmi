$(document).ready(function()
{
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

  $(".like").click(function(){
    $(this).toggleClass('like-active');
    if($(this).hasClass('like-active')){
      $(this).addClass('like-anim');
    } else{
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

  $("#friend").click(function(){
    if($(this).hasClass('friends') || $(this).hasClass('unfriends')){
      var idUserCurrent = $('#data-user').attr("data-number");
      var idUserSelected = $(this).attr("data-number");

      if($(this).hasClass('friends')){
        $(this).removeClass();
        $(this).addClass('unfriends');
      }
      else if($(this).hasClass('accept')){
        $(this).removeClass();
        $(this).addClass('friends');
      }
      else if($(this).hasClass('unfriends')){
        $(this).removeClass();
      }

      $.ajax
      ({
         url: "php/follow.php",
         type: "post",
         data: { idUser_suit: idUserCurrent,
                 idUser_suivit: idUserSelected
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
    }
  });

  $('#edit').click(function(){
    $('.edit').addClass('active');
  });

  $('.edit .close').click(function(){
    $('.edit').removeClass('active');
  });

  $('input').focus(function(){
    $('label').removeClass('active');
    $(this).parent().addClass('active');
  });

  $(".popup-titre-single").click(function(){
    var id_popup = $(this).attr('id');

    $('.popup-titre-single').removeClass('active');
    $('#'+id_popup).addClass('active');

    $('.popup-contents').removeClass('active');
    $('#content-'+id_popup).addClass('active');
  });

  var nbNewTravails = 0;

  function createChamp(i){
    var champTravail = '<div class="ligne ligne-6" data-number="'+i+'">';
    champTravail += '<label for="popup-debutTravail-new-'+i+'">Date de début<input type="date" name="debutTravail-new-'+i+'" id="popup-debutTravail-new-'+i+'" /></label>';
    champTravail += '<label for="popup-finTravail-new-'+i+'">Date de fin<input type="date" name="finTravail-new-'+i+'" id="popup-finTravail-new-'+i+'" /></label>';
    champTravail += '<label for="popup-fonctionTravail-new-'+i+'">Poste<input type="text" name="fonctionTravail-new-'+i+'" id="popup-fonctionTravail-new-'+i+'" /></label>';
    champTravail += '<label for="popup-entrepriseTravail-new-'+i+'">Entreprise<input type="text" name="entrepriseTravail-new-'+i+'" id="popup-entrepriseTravail-new-'+i+'" /></label>';
    champTravail += '<label for="popup-villeTravail-new-'+i+'">Ville<input type="text" name="villeTravail-new-'+i+'" id="popup-villeTravail-new-'+i+'" /></label>';
    champTravail += '<button class="supprimer" type="button" data-number="'+i+'"><span>Supprimer</span></button></div>';

    return champTravail;
  }

  let btn_ajout = document.getElementsByClassName('newField');
  let btn_suppr = document.getElementsByClassName('supprimer');

  for(let i=0; i<btn_ajout.length; i++){
    btn_suppr = document.getElementsByClassName('supprimer');

    btn_ajout[i].addEventListener('click', function(){
      nbNewTravails++;
      var champTravail = createChamp(nbNewTravails);
      document.getElementById("nbNewTravails").value = nbNewTravails;

      $("#nouveauxChamps").append(champTravail);

      $('button.supprimer').click(function(){
        if($(this).parent().parent().attr('id') == 'nouveauxChamps'){
          $(this).parent().remove();

          if(nbNewTravails > 0)
          {
            nbNewTravails--;
            document.getElementById("nbNewTravails").value = nbNewTravails;
          }
        }
      });

      $('input').focus(function(){
        $('label').removeClass('active');
        $(this).parent().addClass('active');
      });
        $.ajax
        ({
           url: "php/follow.php",
           type: "post",
           data: { idUser_suit: idUserCurrent,
                   idUser_suivit: idUserSelected
                  },
          success: function (response)
          {
            if(response == 'ajout')
            {
              $("#nbFollower").text(parseInt($("#nbFollower").text())+1);
              if($("#nbFollower").text() == '2')
              {
                $(".textFolower").text('Relations');
              }
            }
            else if(response == 'suppression')
            {
              $("#nbFollower").text(parseInt($("#nbFollower").text())-1);
              if($("#nbFollower").text() == '1')
              {
                $(".textFolower").text('Relation');
              }
            }
          },
           error: function(jqXHR, textStatus, errorThrown)
           {
              console.log(textStatus, errorThrow);
           }
        });
      }
    });
  }

  $('button.supprimer').click(function(){
    if($(this).parent().parent().attr('id') != 'nouveauxChamps'){
      var idTravailDans = $(this).attr("data-number");
      $(this).parent().remove();

      $.ajax
      ({
         url: "php/modification.php",
         type: "post",
         data: { removeTravail: true,
                 idTravailDans: idTravailDans
                },
        success: function (response) {
          $(".travail-"+idTravailDans).remove();
          document.getElementById("nbOldTravails").value--;
        },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrow);
         }
      });
    }
  });

});
