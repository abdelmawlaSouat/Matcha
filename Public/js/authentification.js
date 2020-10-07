function showMsg(input, feedback_div, errorMsg, type_msg)
{
  if (type_msg === "error")
  {
    inputClass = "is-invalid";
    feedbackClass = "invalid-feedback";
  }
  else
  {
    inputClass = "is-valid";
    feedbackClass = "valid-feedback";
  }
  if (input.hasClass(inputClass) === false)
    input.addClass(inputClass);
  feedback_div.addClass(feedbackClass);
  feedback_div.html(errorMsg);
}

function removeMsg(input, feedback_div, type_msg)
{
  if (type_msg === "error")
  {
    inputClass = "is-invalid";
    feedbackClass = "invalid-feedback";
  }
  else
  {
    inputClass = "is-valid";
    feedbackClass = "valid-feedback";
  }
  if (input.hasClass(inputClass))
    input.removeClass(inputClass);
  feedback_div.removeClass(feedbackClass);
  feedback_div.html("");
}

$(function() {

/*
* Event de focus sur le input
*/

$(".signUpForm input").focus(function() {

  $(this).keyup(function() {
    switch ($(this).attr("name")) {
      case "login":
        if ($(this).val().length < 8)
          showMsg($(this), $(this).next(), "Le nom d'utilisateur doit être au minimum de 8 caractères.", "error");
        else
          removeMsg($(this), $(this).next(), "error");
        break;
      case "name":
      case "firstname":
        var validFormat = /^[a-zàéèçù\-]+$/gi;
        if (validFormat.test($(this).val()) === false)
          showMsg($(this), $(this).next(), "Champ invalide !", "error");
        else
          removeMsg($(this), $(this).next(), "error");
        break;
      case "email":
        var validFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (validFormat.test($(this).val()) === false)
          showMsg($(this), $(this).next(), "L'adresse e-mail est invalide.", "error");
        else
          removeMsg($(this), $(this).next(), "error");
        break;
      case "passwd1":
      case "passwd": /* Le input du formulaire de connexion */
        if ($(this).val().length < 8)
          showMsg($(this), $(this).next(), "Le mot de passe doit être au minimum de 8 caractères.", "error");
        else
          removeMsg($(this), $(this).next(), "error");
        break;
      case "passwd2":
        if ($(this).val() != $("input[name=passwd1]").val())
          showMsg($(this), $(this).next(), "Les mots de passe ne correspondent pas.", "error");
        else if ($(this).val() == "")
          showMsg($(this), $(this).next(), "Mot de passe vide.", "error");
        else
          removeMsg($(this), $(this).next(), "error");
        break;
      default:
    }
  });

});

/*
* Event de unfocus sur le input
*/

$(".signUpForm input").blur(function(e) {

  if ($(this).next().html() == "")
  {
    var input = $(this);
    var feedback = $(this).next();

    if (input.hasClass("check_input"))
    {
      $.post("http://localhost/Matcha/index.php?request=authentification.signUp.checkInput",
      { nameColone: $(this).attr("name"), inputVal: $(this).val() },
      function(data) {
        if (data === "1")
          showMsg(input, feedback, "Déja Pris ! :(", "error");
        else if (input.val() != "")
          showMsg(input, feedback, "Champ valide ! :)", "valid");
      });
    }
    else
      showMsg(input, feedback, "Champ valide ! :)", "valid");
  }
});

/*
* Event d'envoi du formulaire (bloque l'envoie si les données sont invalides)
*/

$(".signUpForm").submit(function (e) {
    if ($(".is-invalid").length > 0)
      e.preventDefault();
});

});

/*
** SIGN IN en AJAX
*/

$(".signIn--button").on('click', function(){
  $.post("http://localhost:8888/Matcha/index.php?request=authentification.signIn.sendData",
  {login: $(".login--input").val(),
   passwd: $(".passwd--input").val()},
   function(data){
      if (data == '1')
        window.location.href = "http://localhost:8888/matcha/index.php?request=userSession.profilsSuggestion.index";
      else
      {
        // GERER L'AFFICHAGE DU MESSAGE D'ERREUR
      }
     });
   });
