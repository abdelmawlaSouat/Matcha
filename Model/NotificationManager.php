<?php

namespace Matcha\Model;

use Matcha\Core\Model;
use Matcha\Core\Notification;

class NotificationManager extends Model
{

  public function add($notification)
  {
    $sqlReq = "INSERT INTO notification(id_sender, id_receiver, type, status, notif_date)
              VALUES(:id_sender, :id_receiver, :type, :status, NOW())";
    $params =  array(
      "id_sender" => $notification->id_sender(),
      "id_receiver" => $notification->id_receiver(),
      "type" => $notification->type(),
      "status" => "unseen",
    );
    $req = $this->setDbRequest($sqlReq, $params);

  }

  public function getAllUserNotifs($user_id)
  {
    $sqlReq = "SELECT * FROM notification WHERE id_receiver = ". $user_id . " ORDER BY id DESC";
    $req = $this->setDbRequest($sqlReq);
    $data = $req->fetchAll(\PDO::FETCH_ASSOC);

    return $data;
  }

  public function getAllUserNotifsUnseen($user_id)
  {
    $sqlReq = "SELECT * FROM notification WHERE id_receiver = ? AND status = ?";
    $req = $this->setDbRequest($sqlReq, array($user_id, "unseen"));


    $count = $req->rowCount();
    $data = $req->fetchAll(\PDO::FETCH_ASSOC);


    return $count;
  }


}
