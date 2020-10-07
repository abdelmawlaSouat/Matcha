
<section class="user_settings_section d-flex justify-content-center">

  <div class="user_settings d-flex">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="nav-link active" id="v-pills-general-tab" data-toggle="pill" href="#v-pills-general" role="tab" aria-controls="v-pills-general" aria-selected="true">Général</a>
      <a class="nav-link" id="v-pills-complementaire-tab" data-toggle="pill" href="#v-pills-complementaire" role="tab" aria-controls="v-pills-complementaire" aria-selected="false">Complémentaire</a>
      <a class="nav-link" id="v-pills-password-tab" data-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-password" aria-selected="false">Mot de passe</a>
      <a class="nav-link" id="v-pills-interests-tab" data-toggle="pill" href="#v-pills-interests" role="tab" aria-controls="v-pills-interests" aria-selected="false">Intérêts</a>
      <a class="nav-link" id="v-pills-pictures-tab" data-toggle="pill" href="#v-pills-pictures" role="tab" aria-controls="v-pills-pictures" aria-selected="false">Photos</a>
      <a class="nav-link" id="v-pills-match-tab" data-toggle="pill" href="#v-pills-match" role="tab" aria-controls="v-pills-match" aria-selected="false">Paramètre de Match</a>
      <a class="nav-link" id="v-pills-blocage-tab" data-toggle="pill" href="#v-pills-blocage" role="tab" aria-controls="v-pills-blocage" aria-selected="false">Personnes Bloqués</a>
    </div>

    <div class="tab-content" id="v-pills-tabContent">
      <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
        <?php require("./View/UserSession/UserSettings/general_form.php"); ?>
      </div>
      <div class="tab-pane fade" id="v-pills-complementaire" role="tabpanel" aria-labelledby="v-pills-complementaire-tab">
        <?php require("./View/UserSession/UserSettings/complement_form.php"); ?>
      </div>
      <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
        <?php require("./View/UserSession/UserSettings/password_form.php"); ?>
      </div>
      <div class="tab-pane fade" id="v-pills-interests" role="tabpanel" aria-labelledby="v-pills-interests-tab">
        <?php require("./View/UserSession/UserSettings/interests_form.php"); ?>
      </div>
      <div class="tab-pane fade" id="v-pills-pictures" role="tabpanel" aria-labelledby="v-pills-pictures-tab">
        <?php require("./View/UserSession/UserSettings/pictures_form.php"); ?>
      </div>
      <div class="tab-pane fade" id="v-pills-match" role="tabpanel" aria-labelledby="v-pills-match-tab">
        <?php require("./View/UserSession/UserSettings/match_form.php"); ?>
      </div>
      <div class="tab-pane fade" id="v-pills-blocage" role="tabpanel" aria-labelledby="v-pills-blocage-tab">
        <?php require("./View/UserSession/UserSettings/complement_form.php"); ?>
      </div>
    </div>
  </div>

</section>
