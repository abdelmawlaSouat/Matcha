<div class="d-flex flex-column align-items-center auth_form">
      <header>
          <img src="public/img/logo/logo.png" alt="Logo" width=100 height=100>
          <h1 class="color_red">Inscription à Matcha</h1>
      </header>

      <section>
        <?php
          if (isset($datas["errorMsg"]))
              echo "<div class='alert alert-danger' role='alert'>". $datas["errorMsg"] ."</div>";
        ?>

        <form class="signUpForm" method="post" action="index.php?request=authentification.signUp.sendData">
            <label for="login">Nom d'utilisateur</label>
            <input type="text" name="login" class="form-control check_input" required>
            <div class="feedback"></div>

            <div class="name_firstname_div">
              <div class="name_div">
                <label for="name">Nom</label>
                <input type="text" name="name" class="form-control" required>
                <div class="feedback"></div>
              </div>
              <div>
                <label for="firstname">Prénom</label>
                <input type="text" name="firstname" class="form-control" required>
                <div class="feedback"></div>
              </div>
            </div>

            <label for="mail">Adresse email</label>
            <input type="email" name="email" class="form-control check_input" required>
            <div class="feedback"></div>

            <label for="passwd1">Mot de passe</label>
            <input type="password" name="passwd1" class="form-control" required>
            <div class="feedback"></div>

            <label for="passwd2">Répétez le mot de passe</label>
            <input type="password" name="passwd2" class="form-control" required>
            <div class="feedback"></div>

            <button type="submit" name="sign_up_btn" class="btn bg_red color_white">Inscription</button>
        </form>
        <div>
            <p>Vous avez un compte ? <a href="index.php?request=authentification.signIn.index" class="color_red">Connectez-vous.</a></p>
        </div>
    </section>
</div>
