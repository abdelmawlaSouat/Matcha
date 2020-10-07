<div class="d-flex flex-column align-items-center auth_form">
  <header>
    <img src="public/img/logo/logo.png" alt="Logo" width=100 height=100>
    <h1 class="color_red">Connexion à Matcha</h1>
  </header>

  <section>
    <?php
      if (isset($datas["errorMsg"]))
          echo "<div class='alert alert-danger' role='alert'>". $datas["errorMsg"] ."</div>";
    ?>

    <form class="signInForm" method="post" action="">
            <label for="login">Nom d'utilisateur</label>
            <input type="text" name="login" class="login--input form-control" required>

            <label for="passwd">Mot de passe</label>
            <input type="password" name="passwd" class="passwd--input form-control" required>

            <button type="button" name="sign_in_btn" class="btn bg_red color_white signIn--button">Connexion</button>
            <p><a href="index.php?request=authentification.recoverPasswd.step_1" class="color_red">Mot de passe oublié ?</a></p>
    </form>

    <div>
      <p>Nouveau sur Matcha ? <a href="index.php?request=authentification.signUp.index" class="color_red">Créer un compte.</a></p>
    </div>
  </section>
</div>
