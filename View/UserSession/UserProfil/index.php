
<section class="user_profil d-flex flex-column align-items-center">

  <header class="d-flex justify-content-between align-items-center">

    <div class="user_info_1 d-flex justify-content-around align-items-center">
      <?php
        if (!empty($_SESSION["avatar"]))
        {
          if (strpos($_SESSION["avatar"], "http") !== false){
            echo '<img src="'.$_SESSION["avatar"].'" alt="Photo du profil" width="150" height="188">'
          ;}
          else
          {
           echo
          '<img src="public/img/users/'.$_SESSION["id"].'/'.$_SESSION["avatar"].'" alt="Photo du profil" width="150" height="188">';
          }
        }
        // echo "<img src='public/img/users/";
        // if (!empty($_SESSION["avatar"]))
        //   echo $_SESSION['id'] . "/" . $_SESSION['avatar'] . "' alt='Avatar' width='150' height='188'>";
        else
          echo "man.png'" .  "alt='Avatar' width='150' height='150'>";
      ?>

      <div class="d-flex flex-column justify-content-around">
        <span class="user_name">
          <?= ucfirst($_SESSION["firstname"]) . " " . ucfirst($_SESSION["name"]); ?>
          <?php if ($datas["age"] > 0) echo ", " . $datas["age"]; ?>
        </span>
        <span class="user_job"><?= ucfirst($_SESSION["job"]); ?></span>
        <div class="location">
          <img src="public/img/icons/location.png" alt="Localisation" width="20" height="20">
          <span><?php echo $_SESSION['match_preferences']['location']['formatted'] ?></span>
        </div>
      </div>
    </div>

    <div class="settings_div">
      <a href="index.php?request=userSession.userSettings.index"><img src="public/img/icons/edit.png" alt="Settings" width="35" height="35"></a>
    </div>
  </header>

  <div class="user_info_2 d-flex">

    <div class="bio_div">
      <h3>Bio :</h3>
      <?php
        if (!empty($_SESSION["bio"]))
          echo "<p>" . $_SESSION["bio"] . "</p>";
        else
          echo "<p>Aucune biographie pour le moment. Décris toi en quelques mots.</p>";
      ?>
    </div>

    <div class="user_info_3 d-flex flex-column align-items-start">
      <h3>Informations complémentaires :</h3>
      <span>Genre : <?= ucfirst($_SESSION["gender"]) ?></span>
      <span>Orientation sexuelle : hétéro</span>
      <span>Date de naissance: <?= (new \Datetime($_SESSION["birthdate"]))->format("d-m-Y"); ?></span>
    </div>

  </div>

  <div class="user_interests d-flex flex-column align-items-start">
    <h3>Intérêts : </h3>
    <div class="interests_list d-flex justify-content-start flex-wrap">
<?php
      if (empty($datas["interests"]))
        echo "<p>Aucun centre d'intérêts pour le moment. Ajoute en au minimum 5 pour pouvoir matcher avec d'autres personnes.</p>";

      for ($i=0; $i < count($datas["interests"]); $i++)
      {
        $interest = $datas["interests"][$i];
        echo "<div class='interest' id='". $interest["id"] ."'><span>#". ucfirst($interest["interest"]) ."</span></div>";
      }
 ?>
    </div>
  </div>

  <div class="user_pictures">
    <h3>Photos :</h3>
    <?php
      if (empty($_SESSION["pictures"]))
        echo "<p>Aucune photo pour le moment. Ajoute en au minimum une pour pouvoir matcher avec d'autres personnes.</p>";
     ?>
    <div class="pictures_list d-flex justify-content-start align-items-center flex-wrap">
      <?php
        if (isset($_SESSION["pictures"]))
        {
          foreach ($_SESSION["pictures"] as $picture)
          {
            if (strpos($picture, "http") !== false){
              echo '<img src="'.$picture.'" alt="Photo du profil" width="200" height="250">'
            ;}
            else
            {
             echo
            '<img src="public/img/users/'.$_SESSION["id"].'/'.$picture.'" alt="Photo du profil" width="200" height="250">';
            }
          }
        }
       ?>
    </div>

  </div>

</section>
