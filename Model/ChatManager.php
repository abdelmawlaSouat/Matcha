<?php

namespace Matcha\Model;

use Matcha\Core\Model;
use Matcha\Core\User;
use \PDO;
/**
 * Design factory for user manager
 */

 class ChatManager extends Model
 {
   private $_conversations = [];
   private $_chat;

   function __construct()
   {
     $this->_conversations = $this->getConversations();
   }
   public function conversations()
   {
     return ($this->_conversations);
   }
   public function chat()
   {
     return ($this->_chat);
   }
   private function getConversations()
   {
     $i = 0;
     $data = [];
     if (!empty($_SESSION["match_array"]))
     {
       $match_array = explode(", ", $_SESSION['match_array']);
       $matchCounter = sizeof($match_array);
       while ($i < $matchCounter)
       {
         $sqlReq = "SELECT * FROM users WHERE id = ?";
         $params = array(
           $match_array[$i]
         );
         $req = $this->setDbRequest($sqlReq, $params);
         $reqArray = $req->fetch();
         $data[] = $reqArray;
         $i++;
     }
   }
   return ($data);
   }
   public function getChat($match)
   {
     $chat_array = [];
     $i = 0;

     $sqlReq = "SELECT * FROM chat WHERE (id_user = ? AND id_match = ?) OR (id_user = ? AND id_match = ?)";
     $params = array(
       $_SESSION['id'],
       $match['id'],
       $match['id'],
       $_SESSION['id']
     );
     $req = $this->setDbRequest($sqlReq, $params);
     while ($data = $req->fetch(PDO::FETCH_ASSOC))
     {
       $chat_array[] = $data;
     }
     return ($chat_array);
   }
   public function add($message, $match)
   {
     $id = $match['id'];

     $sqlReq = "INSERT INTO chat(id_user,id_match,message) VALUES (?,?,?)";
     $params = array(
       $_SESSION['id'],
       $id,
       $message
     );
    $this->setDbRequest($sqlReq, $params);
   }
 }

 ?>
