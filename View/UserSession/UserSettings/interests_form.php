<form class="d-flex flex-column align-items-end" action="" method="post">

  <div class="user_interests">
    <h3>Intérêts : </h3>
    <div class="interests_list d-flex justify-content-center flex-wrap">
    <?php

      for ($i=0; $i < count($datas["interests"]); $i++)
      {
        $interest = $datas["interests"][$i];
        if (is_array($_SESSION["interests"]) && in_array($interest["id"], $_SESSION["interests"]))
          $checked = "checked";
        else
          $checked = "";
        echo "<div class='interest ". $checked ."' id='". $interest["id"] ."'><span>#". ucfirst($interest["interest"]) ."</span></div>";
      }


    ?>
    </div>
  </div>

</form>
