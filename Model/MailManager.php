<?php

namespace Matcha\Model;

use Matcha\Core\Model;
use Matcha\Model\UserManager;
use Matcha\Core\Mail;

class MailManager extends Model
{
  private $_userManager;
  private $_mail;

  public function __construct($title = null, $msg = null)
  {
    $this->setUserManager();
    $this->setMail($title, $msg);
  }

  public function getMail() { return $this->_mail; }
  public function userManager() { return $this->_userManager;}

  public function setUserManager() { $this->_userManager = new UserManager(); }
  public function setMail($title, $msg) { $this->_mail = new Mail($title, $msg); }

  public function stockeKey($login)
  {
    $sql = "UPDATE users SET activation_key = ? WHERE login = ?";
    $params = array($this->_mail->key(), $login);
    $req = $this->_userManager->setDbRequest($sql, $params);
  }



}
