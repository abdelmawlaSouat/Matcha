<div class="filters_list d-flex justify-content-center">

  <div class="dropdown">
    <div data-toggle="dropdown" aria-expanded="false">
      <button class="btn" type="button" name="button">Âge</button>
    </div>
    <div class="dropdown-menu">
      <form class="age_div">
        <p class="d-flex justify-content-between align-items-center" style="width:100%;">
          <label  class="" for="age">Tranche d'âge :</label>
          <span id="age" ><?= $_SESSION["match_preferences"]["ageSlice"];  ?></span>
        </p>
        <div id="age_slider" class="offset-lg-1 col-lg-11"></div>
      </form>
    </div>
  </div>

  <div class="dropdown">
    <div data-toggle="dropdown" aria-expanded="false">
      <button class="btn" type="button" name="button">Score de Popularité</button>
    </div>
    <div class="dropdown-menu">
      <form class="score_div">
        <p class="d-flex justify-content-between align-items-center" style="width:100%;">
          <label  class="" for="score">Tranche de Score :</label>
          <span id="score" >0.1 - 0.9</span>
        </p>
        <div id="score_slider" class="offset-lg-1 col-lg-11"></div>
      </form>
    </div>
  </div>

  <div class="dropdown">
    <div data-toggle="dropdown">
      <div><button class="btn" type="button" name="button">Intérêts</button></div>
    </div>
    <div class="dropdown-menu">
      <form class="interests_list d-flex justify-content-center flex-wrap">
      <?php
        for ($i=0; $i < count($datas["interests"]); $i++)
        {
          $interest = $datas["interests"][$i];
          echo "<div class='interest' id='". $interest["id"] ."'><span>#". ucfirst($interest["interest"]) ."</span></div>";
        }
      ?>
    </form>
    </div>

  </div>

  <div class="dropdown">
    <div data-toggle="dropdown">
      <div><button class="btn" type="button" name="button">Distance</button></div>
    </div>
    <div class="dropdown-menu">
      <form class="distance_div">
        <p class="d-flex justify-content-between align-items-center" style="width:100%;">
          <label  class="" for="distance">Distance maximale (km) :</label>
          <span id="distance" ><?= $_SESSION["match_preferences"]["distanceMax"];  ?></span>
        </p>
        <div id="distance_slider" class="offset-lg-1 col-lg-11"></div>
      </form>
    </div>

  </div>

  <div><button class="apply_filter_btn btn bg_red color_white" type="button" name="button">Appliquer</button></div>
</div>
