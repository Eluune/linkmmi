// Gérer les relations entre les utilisateurs
$("#friend").click(function()
{
  if($(this).hasClass('friends') || $(this).hasClass('unfriends'))
  {
    var idUserCurrent = $('#data-user').attr("data-number");
    var idUserSelected = $(this).attr("data-number");

    if($(this).hasClass('friends'))
    {
      $(this).removeClass();
      $(this).addClass('unfriends');
    }
    else if($(this).hasClass('accept'))
    {
      $(this).removeClass();
      $(this).addClass('friends');
    }
    else if($(this).hasClass('unfriends'))
    {
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
         if(response == 'suppression')
            var nbFollow = $('#nbFollower').text().parseInt() - 1;
         if(response == 'ajout')
            var nbFollow =  $('#nbFollower').text().parseInt() + 1;
         if(response != '')
         {
           $('#nbFollower').text(nbFollow);
           if(nbFollow <= 1)
              $('textFolower').text('Relation');
           else
              $('textFolower').text('Relations');
         }

       },
       error: function(jqXHR, textStatus, errorThrown)
       {
          console.log(textStatus, errorThrow);
       }
    });
  }
});

// Gérer les relations entre les utilisateurs sur la partie suggestion
$(".btn-friend").click(function()
{
  var idUserCurrent = $('#data-user').attr("data-number");
  var idUserSelected = $(this).attr("data-number");

  if($(this).hasClass('wait'))
  {
    $(this).removeClass();
    $(this).addClass('friends');
  }
  else if($(this).hasClass('unfriends'))
  {
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
       console.log(response);
     },
     error: function(jqXHR, textStatus, errorThrown)
     {
        console.log(textStatus, errorThrow);
     }
  });
});

// Gére l'édition du profil
$('#edit').click(function()
{
  $('.edit').addClass('active');
});

$('.edit .close').click(function()
{
  $('.edit').removeClass('active');
});

$('input').focus(function()
{
  $('label').removeClass('active');
  $(this).parent().addClass('active');
});

$(".popup-titre-single").click(function()
{
  var id_popup = $(this).attr('id');

  $('.popup-titre-single').removeClass('active');
  $('#'+id_popup).addClass('active');

  $('.popup-contents').removeClass('active');
  $('#content-'+id_popup).addClass('active');
});

var nbNewTravails = 0;

function createChamp(i)
{
  var champTravail = '<div class="ligne ligne-6" data-number="'+i+'">';
  champTravail += '<label for="popup-debutTravail-new-'+i+'">Date de début<input type="date" name="debutTravail-new-'+i+'" id="popup-debutTravail-new-'+i+'" required /></label>';
  champTravail += '<label for="popup-finTravail-new-'+i+'">Date de fin<input type="date" name="finTravail-new-'+i+'" id="popup-finTravail-new-'+i+'" required /></label>';
  champTravail += '<label for="popup-fonctionTravail-new-'+i+'">Poste<input type="text" name="fonctionTravail-new-'+i+'" id="popup-fonctionTravail-new-'+i+'" placeholder="Étudiant en MMI, Photographe, ..." required /></label>';
  champTravail += '<label for="popup-entrepriseTravail-new-'+i+'">Entreprise<input type="text" name="entrepriseTravail-new-'+i+'" id="popup-entrepriseTravail-new-'+i+'" placeholder="IUT, Université, ..." required /></label>';
  champTravail += '<label for="popup-villeTravail-new-'+i+'">Ville<input type="text" name="villeTravail-new-'+i+'" id="popup-villeTravail-new-'+i+'" placeholder="Paris, Lyon, ..." required /></label>';
  champTravail += '<button class="supprimer" type="button" data-number="'+i+'"><span>Supprimer</span></button></div>';

  return champTravail;
}

let btn_ajout = document.getElementsByClassName('newField');
let btn_suppr = document.getElementsByClassName('supprimer');

for(let i=0; i<btn_ajout.length; i++)
{
  btn_suppr = document.getElementsByClassName('supprimer');

  btn_ajout[i].addEventListener('click', function(){
    nbNewTravails++;
    var champTravail = createChamp(nbNewTravails);
    document.getElementById("nbNewTravails").value = nbNewTravails;

    $("#nouveauxChamps").append(champTravail);

    $('button.supprimer').click(function()
    {
      if($(this).parent().parent().attr('id') == 'nouveauxChamps'){
        $(this).parent().remove();

        if(nbNewTravails > 0)
        {
          nbNewTravails--;
          document.getElementById("nbNewTravails").value = nbNewTravails;
        }
      }
    });

    $('input').focus(function()
    {
      $('label').removeClass('active');
      $(this).parent().addClass('active');
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
    });
  });
}

$('button.supprimer').click(function(){
  if($(this).parent().parent().attr('id') != 'nouveauxChamps')
  {
    var idTravailDans = $(this).attr("data-number");
    $(this).parent().remove();

    $.ajax
    ({
       url: "php/modification.php",
       type: "post",
       data: { removeTravail: true,
               idTravailDans: idTravailDans
              },
      success: function (response)
      {
        $(".travail-"+idTravailDans).remove();
        document.getElementById("nbOldTravails").value--;
      },
       error: function(jqXHR, textStatus, errorThrown)
       {
          console.log(textStatus, errorThrow);
       }
    });
  }
});
