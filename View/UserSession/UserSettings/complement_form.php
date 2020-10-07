<form class="complement_form d-flex flex-column align-items-end" action="" method="post">
  <div>
    <h3>Informations complémentaires</h3>
    <div class='alert d-none' role='alert'>
      <span></span>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>
  </div>

  <div class="d-flex align-items-center">
    <label class="col col-lg-2" for="user_job">Fonction</label>
    <input type="text" class="clearable form-control" name="user_job" value="<?= ucfirst($_SESSION["job"]) ?>" required>
  </div>

  <div class="d-flex align-items-center">
    <label class="col col-lg-2" for="user_bio">Bio</label>
    <textarea name="user_bio" class="form-control"><?= $_SESSION["bio"]; ?></textarea>
  </div>


  <button type="button" class="btn btn-primary edit_profil_btn" name="update_complem_data_btn">Mettre à jour</button>
</form>
