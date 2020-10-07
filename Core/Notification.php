<?php

namespace Matcha\Core;


class Notification
{
  private $_id;
  private $_id_receiver;
  private $_id_sender;
  private $_type;
  private $_date;

  public function __construct($idReceiver, $idSender, $type)
  {
    $this->setIdReceiver($idReceiver);
    $this->setIdSender($idSender);
    $this->setType($type);
  }

  public function type() { return ($this->_type); }
  public function id_receiver() { return ($this->_id_receiver); }
  public function id_sender() { return ($this->_id_sender); }

  public function setType($type)
  {
    $this->_type = $type;
  }
  public function setIdReceiver($idReceiver)
  {
    $this->_id_receiver = $idReceiver;
  }
  public function setIdSender($idSender)
  {
    $this->_id_sender = $idSender;
  }

  public static function getTimeInterval($date)
  {
    date_default_timezone_set("Europe/Brussels");

    $date = new \DateTime($date);
    $now_date = new \DateTime();
    $interval = $date->diff($now_date);

    if ($interval->y > 0)
    $s = $interval->y." a";
    else if ($interval->m > 0)
    $s = $interval->m." m";
    else if ($interval->d > 0)
    $s = $interval->d." j";
    else if ($interval->h > 0)
    $s = $interval->h." h";
    else if ($interval->i > 0)
    $s = $interval->i." min";
    else
    $s = $interval->s." s";
    return $s;
  }

}
