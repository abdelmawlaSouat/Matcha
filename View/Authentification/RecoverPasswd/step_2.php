<div class="recover_passwd d-flex justify-content-center flex-column align-items-center">

  <section class="step_2">
      <header>
        <img src="public/img/icons/send.png" alt="mail send !" width="80" height="80">
        <h2>Code envoyé !</h2>
        <?php
        if (isset($datas["errorMsg"]))
        echo "<div class='alert alert-danger' role='alert'>". $datas["errorMsg"] ."</div>";
        ?>
        <p>Entrez le code envoyé à votre adresse e-mail pour terminer la vérification </p>
      </header>
      <form method="post" action="index.php?request=authentification.recoverPasswd.nextStep&user_login=<?php if (isset($_GET["user_login"])) echo htmlspecialchars($_GET["user_login"]);  ?>">
          <label for="activation_key">Code de vérification</label>
          <input type="text" name="activation_key" class="form-control" required>

          <button type="submit" name="get_key_btn" class="btn bg_red color_white">Envoyer le code</button>
      </form>

      <div class="back_to_home_div">
        <a href="index.php?request=authentification.signIn.index">Revenir à l'écran de connexion</a>
      </div>
  </section>


</div>
