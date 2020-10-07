<form class="general_form d-flex flex-column align-items-end" action="" method="post">
  <div class="">
    <h3>Informations généraux</h3>
    <div class='alert d-none' role='alert'>
      <span></span>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>
  </div>
  <div class="d-flex">
    <?php
      if (!empty($_SESSION["avatar"]))
      {
        if (strpos($_SESSION["avatar"], "http") !== false){
          echo '<img src="'.$_SESSION["avatar"].'" alt="Avatar" width="80" height="80" class="user_avatar">';
        }
        else
        {
         echo
        '<img src="public/img/users/'.$_SESSION["id"].'/'.$_SESSION["avatar"].'" alt="Avatar" width="80" height="80" class="user_avatar">';
        }
      }
      else
        echo '<img src="public/img/users/man.png" alt="Avatar" class="user_avatar" width="80" height="80">';
    ?>

    <div class="d-flex flex-column align-items-start">
      <span class="col offset-lg-1 firstname"><?= ucfirst($_SESSION['firstname']) ?></span>
      <button type="button" class="btn btn-primary btn-light col offset-lg-1 showAvatarModalBtn">Modifier la photo de profil</button>

    </div>
  </div>

  <div class="d-flex align-items-center">
    <label class="col col-lg-3" for="user_name">Nom</label>
    <input type="text" class="clearable form-control" name="user_name" value="<?= ucfirst($_SESSION['name']) ?>" required>
  </div>

  <div class="d-flex align-items-center">
    <label class="col col-lg-3" for="user_firstname">Prénom</label>
    <input type="text" class="clearable form-control" name="user_firstname" value="<?= ucfirst($_SESSION['firstname']) ?>" required>
  </div>

  <div class="d-flex align-items-center">
    <label class="col col-lg-3" for="user_email">E-mail</label>
    <input type="email" class="clearable form-control" name="user_email" value="<?= $_SESSION['email'] ?>" required>
  </div>

  <div class="d-flex align-items-center">
    <label class="col col-lg-3" for="user_mail">Date de naissance</label>
    <input type="date" class="form-control" name="user_birthday" value="<?= $_SESSION["birthdate"] ?>" required>
  </div>

  <div class="d-flex align-items-center">
    <label class="col col-lg-3" for="user_genre">Genre</label>
    <select class="form-control" name="user_genre" required>
      <option value=""  <?php if (!isset($_SESSION["gender"])) echo "selected"; ?>>
        Non spécifié
      </option>
      <option value="male" <?php if (isset($_SESSION["gender"]) && $_SESSION["gender"] == "male") echo "selected"; ?>>
        Homme
      </option>
      <option value="female" <?php if (isset($_SESSION["gender"]) && $_SESSION["gender"] == "female") echo "selected"; ?>>
        Femme
      </option>
    </select>
  </div>

  <button type="button" class="btn btn-primary edit_profil_btn" name="update_general_data_btn">Mettre à jour</button>

</form>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modifier la photo de profil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body d-flex justify-content-center">

          <div class="file user_avatar btn btn-lg btn btn-outline-secondary">
            <span>Importer une photo</span>
            <input type="file" class="user_avatar_file" name="user_avatar" accept=".gif,.png,.jpeg,.jpg" required/>
          </div>

          <img class="new_avatar d-none" src="" alt="new Avatar">

        </div>

        <div class="modal-footer d-none">
          <button type="button" class="avatar_back_btn btn btn-secondary">Retour</button>
          <button type="button" class="avatar_update_btn btn btn-primary">Mettre à jour</button>
        </div>
    </div>
  </div>
</div>
