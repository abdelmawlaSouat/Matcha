<div class="container alert_div">
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Inscription réussis !</h4>
    <p class="mb-0">
      Matchez, discutez et rencontrez-vous. Rien n'est plus simple que Matcha :
      si une personne te plaît, like son profil et si elle like en retour,
      c'est un Match !
      Nous avons inventé ce système afin de rapprocher les gens uniquement
      lorsque l'intérêt est réciproque. Pas de stress. Pas de rejet.
      Appuie sur les profils qui t'intéressent pour en découvrir davantage,
      et discutes en ligne avec tes Matchs. Ensuite, pose ton téléphone et
      rencontrez-vous en vrai !
    </p>
    <hr>
    <p>
      Salut, <?= ucfirst($_SESSION["firstname"]) ?> !
      Bienvenue sur Matcha, la plus grande communauté de célibataires au monde !
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
