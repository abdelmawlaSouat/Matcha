<form class="d-flex flex-column pictures_form" action="" method="post">
  <div class="">
    <h3>Photos :</h3>

    <div class='alert d-none' role='alert'>
      <span></span>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>

  </div>
  <div class="user_pictures d-flex flex-column">

    <div class="pictures_list d-flex align-items-center flex-wrap">
      <?php
        if (isset($_SESSION["pictures"]))
        {
          foreach ($_SESSION["pictures"] as $picture)
          {
            echo "<div class='picture_div class='col col-lg-12'>
            <img class='delete_img' src='public/img/icons/delete.png' data-toggle='modal' data-target='#confirm-modal' alt='Delete' width='40' height='40'>";
            if (strpos($picture, "http") !== false){
              echo '<img src="'.$picture.'" alt="Gallerie" width="180" height="225">';
            }
            else
            {
             echo
            '<img src="public/img/users/'.$_SESSION["id"].'/'.$picture.'" alt="Gallerie" width="180" height="225">';
            }
            echo "</div>";
          }
        }
       ?>
      <div class="add_img_div" >
        <img class="add_img" src="public/img/icons/add-image.png" alt="Ajouter une image" width="40" height="40">
      </div>
    </div>
  </div>

</form>


<!-- Modal Add Picture -->
<div class="modal fade" id="addPictureModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ajouter une photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body d-flex justify-content-center">

          <div class="file picture btn btn-lg btn btn-outline-secondary">
            <span>Importer une photo</span>
            <input type="file" class="picture_file" name="picture" accept=".gif,.png,.jpeg,.jpg" required/>
          </div>

          <img class="new_picture d-none" src="" alt="New Picture">

        </div>

        <div class="modal-footer d-none">
          <button type="button" class="picture_back_btn btn btn-secondary">Retour</button>
          <button type="button" class="add_picture_btn btn btn-primary">Mettre à jour</button>
        </div>
    </div>
  </div>
</div>

<!-- Modal Delete Picture -->

<!-- <button class="btn btn-default" id="btn-confirm">Confirm</button> -->

<div class="modal fade" tabindex="-1" id="confirm-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header d-block">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Supprimer la photo ?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="modal-btn-no">Non</button>
        <button type="button" class="btn btn-default" id="modal-btn-yes">Oui</button>
      </div>
    </div>
  </div>
</div>

<div class="alert" role="alert" id="result"></div>
