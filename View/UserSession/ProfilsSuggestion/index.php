<section class="profils_suggestion d-flex flex-column ">

<?php require("filters.php"); ?>

<div class="sort_div d-flex align-items-center justify-content-end">
  <label class="" for="sort_params">Trier par  </label>
  <select class="custom-select col col-lg-1" name="sort_params" required>
    <option value="default">
      Par défaut
    </option>
    <option value="age">
      Âge
    </option>
    <option value="score">
      Popularité
    </option>
    <option value="distance">
      Distance
    </option>
    <option value="interests">
      Intérêts
    </option>
  </select>
</div>

<?php
  if (isset($datas["alert"]))
    require($datas["alert"]);
  else
  {
    echo '<div class="container profils_list d-flex justify-content-center flex-wrap">';
      foreach ($datas["userCards"] as $key => $userCard)
      echo $userCard;
?>
  </div>
<?php
}
?>

<div class="modal fade" tabindex="-1" id="userProfil" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header d-block">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body d-flex justify-content-center"> </div>
    </div>
  </div>
</div>

<div class="alert" role="alert" id="result"></div>


</section>
