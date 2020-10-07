<div class="recover_passwd d-flex flex-column justify-content-center align-items-center">

  <section class="step_3">
    <header class="d-flex flex-column align-items-center">
      <a href="index.php">
        <img src="public/img/logo/logo.png" class="logo_img" alt="Logo" width=100 height=100>
      </a>
      <h2>Réinitialisation du mot de passe</h2>
    </header>
    <?php
      if (isset($datas["errorMsg"]))
          echo "<div class='alert alert-danger' role='alert'>". $datas["errorMsg"] ."</div>";
    ?>
      <form method="post" action="index.php?request=authentification.recoverPasswd.nextStep&user_login=<?php if (isset($_GET["user_login"])) echo htmlspecialchars($_GET["user_login"]); ?>">
        <label  for="new_passwd0">Nouveau mot de passe</label>
        <input type="password" class="form-control" name="new_passwd0" required>

        <label  for="new_passwd1">Confirmer mot de passe</label>
        <input type="password" class="form-control" name="new_passwd1" required>

          <button type="submit" name="reset_passwd_btn" class="btn bg_red color_white">Mettre à jour</button>
      </form>

      <div class="back_to_home_div">
        <a href="index.php?request=authentification.signIn.index">Revenir à l'écran de connexion</a>
      </div>
  </section>


</div>
