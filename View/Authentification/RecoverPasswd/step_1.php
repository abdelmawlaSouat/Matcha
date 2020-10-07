<div class="recover_passwd d-flex flex-column justify-content-center align-items-center">

  <section class="step_1">
      <header>
        <img src="public/img/icons/lock.png" alt="Lock" width="80" height="80">
        <h2>Problèmes de connexion ?</h2>
        <?php
        if (isset($datas["errorMsg"]))
        echo "<div class='alert alert-danger' role='alert'>". $datas["errorMsg"] ."</div>";
        ?>
        <p>Entrez votre adresse e-mail et nous vous enverrons un lien pour récupérer votre compte.</p>
      </header>
      <form method="post" action="index.php?request=authentification.recoverPasswd.nextStep">
          <label for="mail">Adresse e-mail</label>
          <input type="email" name="email" class="form-control" required>

          <button type="submit" name="send_key_btn" class="btn bg_red color_white">Envoyer un lien de connexion</button>
      </form>

      <div class="back_to_home_div">
        <a href="index.php?request=authentification.signIn.index">Revenir à l'écran de connexion</a>
      </div>
  </section>

</div>
