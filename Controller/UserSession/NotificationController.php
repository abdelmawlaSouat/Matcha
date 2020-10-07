<?php

namespace Matcha\Controller\UserSession;

use Matcha\Core\SessionController;
use Matcha\Model\NotificationManager;
use Matcha\Core\Notification;


class NotificationController extends SessionController
{
  public function __construct($request) { parent::__construct($request); }

  public function addNotif()
  {
    $notif_datas = array(
      "idSender" => $_SESSION["id"],
      "idReceiver" => htmlspecialchars($_POST["IdUserCard"]),
      "type" => htmlspecialchars($_POST["type"])
    );

    $notif = new Notification($notif_datas["idReceiver"], $notif_datas["idSender"], $notif_datas["type"]);

    if ($notif_datas["type"] == "like")
    {
      //MY JOB
      $this->notifManager->add($notif);
      echo "OK";
    }
    else if ($notif_datas["type"] == "dislike")
    {

    }
    else if ($notif_datas["type"] == "visit")
    {
      $this->notifManager->add($notif);
      echo "Visit OK";

    }
    else if ($notif_datas["type"] == "message")
    {

    }
    else if ($notif_datas["type"] == "match")
    {

    }
    else if ($notif_datas["type"] == "dismatch")
    {

    }


  }

}
