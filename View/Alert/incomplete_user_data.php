<div class="container alert_div">
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Données Incomplètes !</h4>
    <p>
      Salut, <?= ucfirst($_SESSION["firstname"]) ?> !
      Pour pouvoir commencer à matcher avec d'autres utilisateurs,
      il nous faut encore quelques informations te concernant :
      <ul>
        <?php if (empty($_SESSION["birthdate"])) echo "<li>ta date de naissance</li>"; ?>
        <?php if (empty($_SESSION["gender"])) echo "<li>ton genre</li>"; ?>
        <?php if (!is_array($_SESSION["interests"]) || count($_SESSION["interests"]) < 5) echo "<li>au minimum 5 centres d'intérêts</li>"; ?>
        <?php if (!is_array($_SESSION["pictures"]) || (count($_SESSION["pictures"]) < 1)) echo "<li>au minimum 1 photo de toi</li>"; ?>
      </ul>

      Clique <a href="index.php?request=userSession.userSettings.index">ici</a> pour les ajouter.
    </p>
  </div>
</div>
