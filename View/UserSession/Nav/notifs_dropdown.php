<div class="dropdown notifs_dropdown">
  <div class="nav__icons-notif_div" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
     <span class="notif-counter"><?= $nav_datas["unseenNotifsCount"]; ?></span>
     <img src="public/img/icons/notif.svg" class="notif_img" alt="Notification" width=30 height=30>
  </div>
  <div class="dropdown-menu dropdown-menu-left">
    <span class="dropdown-item-text">Notifications</span>
    <div class="hidden-scrollbar">
      <div class="notifs_container">

        <?php
        foreach ($nav_datas["userNotifs"] as $notif_div) {
          echo $notif_div;
        }
         ?>
      </div>
    </div>

  <div class="dropdown_footer dropdown-item-text d-flex justify-content-center align-items-center">
    <a href="index.php?request=userSession.notification.index">Voir Tout</a>
  </div>

</div>


</div>
