<form class="match_settings d-flex flex-column align-items-end" action="index.html" method="post">
  <div>
    <h3>Préférence de suggestion de profils</h3>

    <div class='alert d-none' role='alert'>
      <span></span>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>
  </div>

  <div class="d-flex align-items-center">
    <div class="col-auto location-bar--div">
      <label class="col-lg-4" for="user_job">Localisation</label>
      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <a href="#" id="reset-location">
              <img src="./Public/img/icons/maps-and-location.png" alt="" width="25" height="25">
            </a>
          </div>
            <input  class="form-control col-lg-9 location_search clearable" type="search" id="inlineFormInputGroup" value="<?php echo ltrim($_SESSION["match_preferences"]["location"]["formatted"]);?>" />
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex">
    <label class="col-lg-4" for="sexePreference">Intéressé par </label>
    <select class="form-control offset-lg-3 col-lg-5 sexePreference" name="sexePreference" required>
      <option value="bi"  <?php if ($_SESSION["match_preferences"]["interessedBy"] == "bi") echo "selected"; ?>>
        Les deux
      </option>
      <option value="male" <?php if ($_SESSION["match_preferences"]["interessedBy"] == "male") echo "selected"; ?>>
        Hommes
      </option>
      <option value="female" <?php if ($_SESSION["match_preferences"]["interessedBy"] == "female") echo "selected"; ?>>
        Femmes
      </option>
    </select>
  </div>

  <div class="">
    <p class="d-flex justify-content-between align-items-center" style="width:100%;">
      <label class="col-lg-6">Distance maximale (km) :</label>
    </p>

    <div id="distance_slider" class="offset-lg-1 col-lg-11">
      <div id="distance" class="ui-slider-handle">
        <?php echo $_SESSION["match_preferences"]["distanceMax"]; ?>
      </div>
    </div>
  </div>

  <div class="age_div">
    <p class="d-flex justify-content-between align-items-center" style="width:100%;">
      <label  class="col-lg-4" for="age">Tranche d'âge:</label>
      <span id="age" ><?= $_SESSION["match_preferences"]["ageSlice"];  ?></span>
    </p>
    <div id="age_slider" class="offset-lg-1 col-lg-11"></div>
  </div>

  <button type="button" class="btn btn-primary edit_match_settings_btn" name="update_match_settings_btn">Mettre à jour</button>
</form>
