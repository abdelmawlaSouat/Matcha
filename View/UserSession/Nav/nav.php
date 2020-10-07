  <header class="nav_container">
    <nav class="container d-flex align-items-center justify-content-between">

          <a href="index.php?request=userSession.profilsSuggestion.index">
                <div class="nav__logo-div">
                      <img  src="public/img/logo/logo.png" alt="Logo" width=30 height=30>
                      <img src="public/img/logo/name.png" alt="Logo" width=100 >
                </div>
          </a>

          <div class="d-flex align-items-center">

            <div class="nav__icons-div d-flex align-items-center">
              <a href="index.php?request=userSession.profilsSearch.index"><img src="public/img/icons/search.png" class="search_img" alt="Search" width=30 height=30></a>
              <a href="index.php?request=userSession.chat.index">
                <div class="nav__icons-notif_div">
                  <span class="notif-counter">55</span>
                  <img src="public/img/icons/chat.png" class="chat_img" alt="Message" width=30 height=30>
                </div>
              </a>
              <?php require("notifs_dropdown.php"); ?>
            </div>

            <?php require("user_dropdown.php"); ?>
          </div>
    </nav>
  </header>
