<?php

namespace Matcha\Controller\Authentification;

use Matcha\Core\Controller;
use Matcha\Core\User;
use Matcha\Model\UserManager;
use Matcha\Model\MailManager;
use Matcha\Core\Session;

class SignInController extends Controller
{
  private $_userManager;
  private $_userSession;

  public function __construct($request)
  {
    parent::__construct($request);
    $this->setUserManager();
    $this->setUserSession();
  }

  public function userManager() { return $this->_userManager;}
  public function userSession() { return $this->_userSession; }

  public function setUserManager() { $this->_userManager = new UserManager(); }
  public function setUserSession() { $this->_userSession = new Session(); }

  public function confirmAccount()
  {
    $login = htmlspecialchars($_GET["login"]);
    $key = htmlspecialchars($_GET["key"]);
    $user_data = $this->_userManager->get("login", $login);

    if ($user_data["activation_key"] == $key)
    {
      $this->_userManager->update($user_data["id"], "activated", 1);
      header("Location: index.php?request=authentification.signIn.index");

    }
    else
    {
      $this->page->setContent("error/404");
      $this->index();
    }

  }

  public function sendData()
  {
    if (isset($_POST["login"]) && isset($_POST["passwd"]))
    {
      $user_data = array(
        "login" => htmlspecialchars(strtolower($_POST["login"])),
        "password" => htmlspecialchars($_POST["passwd"])
      );

      if ($this->_userManager->connect(new User($user_data)))
      {
        $user_array = $this->_userManager->get("login", $user_data["login"]);
        if ($user_array["activated"])
        {
          $this->_userSession->createUserSession($user_array);
          echo "1";
        }
        else
        {
          $this->page->setContent("error/accountNotConfirmed");
          $this->index();
        }
      }
      else
      {
        $datas = array("errorMsg" => "Login et/ou mot de passe incorrect !");
        $this->page->setContent("index", $datas);
        $this->index();
      }
    }
    else
    {
      $this->page->setContent("error/404");
      $this->index();
    }
  }

}
