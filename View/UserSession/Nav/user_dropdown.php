<div class="dropdown">
  <div class="d-flex align-items-center justify-content-end div__user-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="div__user-name"><?= ucfirst($_SESSION['login']) ?></span>
    <?php
      if (!empty($_SESSION["avatar"]))
      {
        if (strpos($_SESSION["avatar"], "http") !== false){
          echo '<img src="'.$_SESSION["avatar"].'" alt="Photo du profil" width="60" height="60" class="user_avatar">'
        ;}
        else
        {
         echo
        '<img src="public/img/users/'.$_SESSION["id"].'/'.$_SESSION["avatar"].'" alt="Photo du profil" width="60" height="60" class="user_avatar">';
        }
      }
      else
        echo '<img src="public/img/users/man.png" alt="Avatar" class="user_avatar" width="60" height="60">';
    ?>
  </div>
  <div class="dropdown-menu">

    <a class="dropdown-item" href="index.php?request=userSession.userProfil.index">
      <img src="public/img/icons/user.svg" alt="My profil" width="25" height="25">
      Mon Profil
    </a>

    <a class="dropdown-item" href="index.php?request=userSession.userSettings.index">
      <img src="public/img/icons/settings.svg" alt="Settings" width="25" height="25">
      Préférence du compte
    </a>
    <a class="dropdown-item" href="index.php?request=userSession.profilsSuggestion.disconnect">
      <img src="public/img/icons/exit.svg" alt="Disconnect" width="25" height="25">
      Déconnexion
    </a>

  </div>
</div>
