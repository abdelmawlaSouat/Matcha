<?php

namespace Matcha\Controller\UserSession;

use Matcha\Model\ChatManager;
use Matcha\Model\UserManager;
use Matcha\Core\SessionController;
/**
 *  chat controller class that handles chat module
 */
class ChatController extends SessionController
{
  private $_chatManager;

  function __construct($request)
  {
    parent::__construct($request);
    $this->setChatManager();
    date_default_timezone_set('Europe/Brussels');
  }
  public function ChatManager()
  {
    return ($this->_chatManager);
  }
  public function setChatManager()
  {
    $this->_chatManager = new ChatManager();
  }
  public function renderConversations()
  {
    $conversations = $this->_chatManager->conversations();
    $conversationsLenght = sizeof($conversations);
    if ($conversationsLenght !== 0)
    {
      for ($i = 0; $i < $conversationsLenght; $i++) {
        $matchName = $conversations[$i]['name'];
        $matchFirstname = $conversations[$i]['firstname'];
        $matchLogin = $conversations[$i]['login'];
        $matchBio = $conversations[$i]['bio'];
        $date = explode('-', $conversations[$i]['birthdate']);
        $matchAge = (date("md", date("U", mktime(0, 0, 0, intval($date[1]), intval($date[2]), intval($date[0])))) > date("md")
        ? ((date("Y") - intval($date[0])) - 1) : (date("Y") - intval($date[0])));
        $matchAvatar = $conversations[$i]['avatar'];
         echo '<div class="chat_list">
                 <div class="match--template">
                   <div class="match-img--div">
                   ';
                   if (strpos($conversations[$i]["avatar"], "http") !== false){
                     echo '<img src="'.$conversations[$i]["avatar"].'" alt="Photo du profil" class="match--img">'
                   ;}
                   else
                   {
                    echo
                   '<img src="public/img/users/'.$conversations[$i]["id"].'/'.$conversations[$i]["avatar"].'" alt="Photo du profil" class="match--img">';
                   }
                  echo '
                   </div>
                   <div class="match-description--div">
                     <h5>'.$matchLogin.'<span class="chat_date--span">'.$matchAge.' ans</span></h5>
                     <p>'.$matchBio.'</p>
                   </div>
                 </div>
               </div>';
      }
    }
  }
  public function renderChat()
  {
    $matchLogin = htmlspecialchars($_POST['login']);
    $matchInfo = $this->userManager->get('login', $matchLogin);
    $chat = $this->_chatManager->getChat($matchInfo);
    $chatLenght = sizeof($chat);
    for ($i = 0; $i < $chatLenght; $i++) {
      $id = $chat[$i]['id_user'];
      $user = $this->userManager->get('id', $id);
      $login = $user['login'];
      $avatar = $user['avatar'];
      if (strpos($avatar, "http") === false)
        $avatar = "public/img/users/" . $id ."/". $avatar;
      $message = $chat[$i]['message'];
      $creation_date = $this->dateCreator($chat[$i]);
      if ($login == $_SESSION['login'])
        echo '<div class="outcoming_message--div message">
                <div class="sent_msg--div">
                  <p class="message--p">'.$message.'</p>
                  <span class="msg_time_date">'.$creation_date.'</span>
                </div>
              </div>';
      else
        echo '<div class="incoming_msg--div message">
                <div class="incoming_msg_img--div">
                  <img src="'.$avatar.'" alt="" class="incoming_msg--img">
                </div>
                <div class="received_msg--div">
                  <div class="received_msg">
                    <p class="message--p">'.$message.'</p>
                    <span class="msg_time_date">'.$creation_date.'</span>
                  </div>
                </div>
              </div>';
    }
  }
  private function dateCreator($message)
  {
    $currentTime = time();
    $creation_date = $message['creation_date'];
    $creation_date = strtotime($creation_date);

    $deltaTime = $currentTime - $creation_date;
    if ($deltaTime < 86401)
      $creation_date = date("H:i, \T\o\d\a\y", $creation_date);
    else
      $creation_date = date("H\hi, j F", $creation_date);

    return ($creation_date);
  }
  public function addMessage()
  {
    $message = htmlspecialchars($_POST['message']);
    $matchLogin = htmlspecialchars($_POST['matchLogin']);

    $matchData = $this->userManager->get("login", $matchLogin);
    $this->_chatManager->add($message, $matchData);
  }
}
