<form class="password_form d-flex flex-column align-items-end" action="" method="post">
  <div class="">
    <h3>Changement de mot de passe</h3>
    <div class='alert d-none' role='alert'>
      <span></span>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>
  </div>

  <div class="d-flex align-items-center">
    <label class="col col-lg-3" for="old_password">Ancien </label>
    <input type="password" class="form-control" name="old_password" required>
  </div>
  <div class="d-flex align-items-center">
    <label class="col col-lg-3" for="new_passwd0">Nouveau </label>
    <input type="password" class="form-control" name="new_passwd0" required>
  </div>
  <div class="d-flex align-items-center">
    <label class="col col-lg-3" for="new_passwd1">Confirmer </label>
    <input type="password" class="form-control" name="new_passwd1" required>
  </div>
  <button type="button" class="btn btn-primary edit_profil_btn" name="update_passwd_btn">Réinitialiser mot de passe</button>

</form>
