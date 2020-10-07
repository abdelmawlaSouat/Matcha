<?php
namespace Matcha\Controller\Authentification;

use Matcha\Core\Controller;
use Matcha\Core\User;
use Matcha\Model\UserManager;
use Matcha\Model\MailManager;

class SignUpController extends Controller
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

  public function checkInput()
  {
    if (isset($_POST["nameColone"]) && isset($_POST["inputVal"]))
    {
      $col = htmlspecialchars($_POST["nameColone"]);
      $val = htmlspecialchars($_POST["inputVal"]);
      echo $this->_userManager->isExist($col, strtolower($val));
    }
  }

  public function sendData()
  {
    if (isset($_POST["login"]) && isset($_POST["name"]) && isset($_POST["firstname"]) &&
    isset($_POST["email"]) && isset($_POST["passwd1"]) && isset($_POST["passwd2"]))
    {
      $user_data = array(
        "login" => htmlspecialchars(strtolower($_POST["login"])),
        "name" => htmlspecialchars(strtolower($_POST["name"])),
        "firstname" => htmlspecialchars(strtolower($_POST["firstname"])),
        "email" => htmlspecialchars($_POST["email"]),
        "password" =>
        // password_hash(htmlspecialchars(
          $_POST["passwd1"],
           // PASSWORD_DEFAULT),
        "match_preferences" => json_encode(array(
          "location" => "", "distanceMax" => "15",
          "interessedBy" => "bi", "ageSlice" => "18 - 90"
        ))
      );

      $valid_login = strlen($user_data["login"]) > 7;
      $valid_name = preg_match("/^[a-zàéèçù\-]+$/i", $user_data["name"]);
      $valid_firstname = preg_match("/^[a-zàéèçù\-]+$/i", $user_data["firstname"]);
      $valid_email = preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $user_data["email"]);
      $valid_password = htmlspecialchars($_POST["passwd1"]) === htmlspecialchars($_POST["passwd2"]) ;

      if ($valid_login && $valid_name && $valid_firstname && $valid_email && $valid_password)
      {
        $key = $this->_mailManager->getMail()->key();
        $title = "Matcha - Confirmer votre compte !";
        $msg ='
        <html>
          <body>
            <div align="center">
              <img src="https://carlisletheacarlisletheatre.org/images/tinder-logo-icon-9.png" width=175 height=175/>
              <br />
              <h1 style="margin-top=12px; margin-bottom=12px;">Bienvenue '.ucfirst($user_data["firstname"]).' !</h1>
              <br />
              <h2 style="margin-top=9px; margin-bottom=9px;">Veuillez confirmer votre compte.</h2>
              <br />
              <a href="http://localhost/Matcha/index.php?request=authentification.signIn.confirmAccount&login='. $user_data["login"] .'&key='. $key .'">
                  <button type="button" name="button" style="background-color: #EC407A; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;">
                     Activer mon compte
                  </button>
              </a>
            </div>
          </body>
        </html>
        ';

        $this->_mailManager->setMail($title, $msg);
        $this->_mailManager->getMail()->setKey($key);
        $this->_mailManager->getMail()->send("19.web.projects@gmail.com");
        $this->_userManager->add($user_data);
        $this->_mailManager->stockeKey($user_data["login"]);
        $this->page->setContent("error/accountNotConfirmed");
        $this->index();
      }
      else
      {
        $datas = array("errorMsg" => "Incorrect ! Veuillez vérifier les champs !");
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

 ?>
