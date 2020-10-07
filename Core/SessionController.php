<?php

namespace Matcha\Core;

use Matcha\Model\NotificationManager;
use Matcha\Model\UserManager;
use Matcha\Core\Notification;

class SessionController extends Controller
{
  protected $userSession;
  protected $notifManager;
  protected $userManager;

  function __construct($request)
  {
    parent::__construct($request);
    $this->setUserSession();
    $this->setNotifManager();
    $this->setUserManager();
  }

  public function setUserSession() { $this->userSession = new Session(); }
  public function userSession() { return $this->userSession; }

  public function userManager() { return $this->userManager;}
  public function setUserManager() { $this->userManager = new UserManager(); }

  public function notifManager() { return $this->notifManager;}
  public function setNotifManager() { $this->notifManager = new NotificationManager(); }

  public function disconnect()
  {
    $this->userSession->destroy();
    header("Location: index.php?request=authentification.signIn.index");
  }


  public function getAllUserNotifsDiv()
  {
    $notifs = $this->notifManager->getAllUserNotifs($_SESSION["id"]);

    $notifsDiv = [];
    foreach($notifs as $key => $notif)
    {
      $sender = $this->userManager->get("id", $notif["id_sender"]);
      $notif["sender_name"] = $sender["firstname"];
      $notif["sender_avatar"] = explode(", ", $sender["pictures"])[0];
      $notif["timeInterval"] = NOTIFICATION::getTimeInterval($notif["notif_date"]);
      $notif_div = $this->page->createElement("View/UserSession/Notification/notif_div.php", $notif);
      array_push($notifsDiv, $notif_div);
    }

    return $notifsDiv;
  }

  public function index()
  {
    $nav_datas = array(
      "userNotifs" => $this->getAllUserNotifsDiv(),
      "unseenNotifsCount" => $this->notifManager->getAllUserNotifsUnseen($_SESSION["id"])
    );
    $this->page->setNav($nav_datas);
    parent::index();

  }

}
