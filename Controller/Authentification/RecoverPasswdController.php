<?php

namespace Matcha\Controller\Authentification;

use Matcha\Core\Controller;
use Matcha\Core\User;
use Matcha\Model\UserManager;
use Matcha\Model\MailManager;

class RecoverPasswdController extends Controller
{
  private $_userManager;
  private $_mailManager;

  public function __construct($request)
  {
    parent::__construct($request);
    $this->setUserManager();
    $this->setMailManager();
  }

  public function userManager() { return $this->_userManager;}
  public function mailManager() { return $this->_mailManager;}

  public function setUserManager() { $this->_userManager = new UserManager(); }
  public function setMailManager() { $this->_mailManager = new MailManager(); }

  public function step()
  {
    $request_array = $this->request->request();
    $view = $request_array["action"];
    $this->page->setContent($view);
    require "View/". $this->page->template();
  }

  public function nextStep()
  {
    if (isset($_POST["send_key_btn"]))
    {
      if (isset($_POST["email"]))
        $email = htmlspecialchars($_POST["email"]);
      if (isset($email) && $this->_userManager->isExist("email", $email))
      {
        $key = $this->_mailManager->getMail()->key();
        $user = $this->_userManager->get("email", $email);
        $title = "Votre code de vérification Matcha";
        $msg = '
        <html>
          <body>
            <div align="center">
              <img src="https://carlisletheacarlisletheatre.org/images/tinder-logo-icon-9.png" width=175 height=100/>
              <br />
              <h1 style="margin-top=12px; margin-bottom=12px;">Bonjour '.ucfirst($user["firstname"]).' !</h1>
              <br />
              <p style="margin-top=9px; margin-bottom=9px;">Veuillez utiliser le code suivant pour terminer la vérification :</p>
              <span style="font-weight:bolder;  color: DodgerBlue; font-size:20px;">'.$key.'</span>
            </div>
          </body>
        </html>
        ';
        $this->_mailManager->setMail($title, $msg);
        $this->_mailManager->getMail()->setKey($key);
        $this->_mailManager->getMail()->send("19.web.projects@gmail.com");
        $this->_mailManager->stockeKey($user["login"]);
        header("Location: index.php?request=authentification.recoverPasswd.step_2&user_login=". $user["login"]);
      }
      else {
        $datas = array("errorMsg" => "Email introuvable !");
        $this->page->setContent("step_1", $datas);
        $this->step();
      }

    }
    else if (isset($_POST["get_key_btn"]))
    {
      if (isset($_GET["user_login"]))
      {
        $login = htmlspecialchars($_GET["user_login"]);
        $user = $this->_userManager->get("login", $login);
        if ($user["activation_key"] == $_POST["activation_key"])
          header("Location: index.php?request=authentification.recoverPasswd.step_3&user_login=". $user["login"]);
        else
        {
          $datas = array("errorMsg" => "Code incorrect !");
          $this->page->setContent("step_2", $datas);
          $this->step();
        }
      }
    }
    else if (isset($_POST["reset_passwd_btn"]))
    {
      if (isset($_GET["user_login"]))
      {
        $login = htmlspecialchars($_GET["user_login"]);
        $user = $this->_userManager->get("login", $login);

        if ((strlen($_POST["new_passwd0"]) >= 8) && ($_POST["new_passwd0"] == $_POST["new_passwd1"]))
        {
          $new_password = password_hash(htmlspecialchars($_POST["new_passwd0"]), PASSWORD_DEFAULT);
          $this->_userManager->update($user["id"], "password", $new_password);
          header("Location: index.php?request=authentification.signIn.index");

        }
        else
        {
          if (strlen($_POST["new_passwd0"]) < 8)
            $msg = "Le nouveau mot de passe doit comporter au moins 8 caractères !";
          else if ($_POST["new_passwd0"] != $_POST["new_passwd1"])
            $msg = "Les nouveaux mots de passe ne correspondent pas !";

          $datas = array("errorMsg" => $msg);
          $this->page->setContent("step_3", $datas);
          $this->step();
        }
      }
    }
  }




}
