<?php

namespace Matcha\Core;

class Session
{
    public function __construct(){
     }

    public function destroy() { session_destroy(); }
    public function setAttribut($name, $value) { $_SESSION[$name] = $value; }

    public function existAttribut($name) { return (isset($_SESSION[$name]) && $_SESSION[$name] != ""); }

    public function createUserSession($user_data)
    {
      $sessionData = array(
        "id", "login", "name", "firstname", "birthdate", "email", "job",
        "gender", "match_preferences", "bio", "pictures", "interests", "match_array", "location_status"
      );

      $this->setAttribut("auth", 1);
      for ($i=0; $i < count($sessionData); $i++)
      {
        $attr = $sessionData[$i];
        if ( (($attr == "pictures") || ($attr == "interests")) && !(empty($user_data[$attr])) )
        {
          $array = explode(", ", $user_data[$attr]);
          $this->setAttribut($attr, $array);
          if ($attr == "pictures")
            $this->setAttribut("avatar", $array[0]);
        }
        else if ($attr == "match_preferences" && !(empty($user_data[$attr])))
        {
          $matchSettings = json_decode($user_data[$attr], true);
          $this->setAttribut($attr, $matchSettings);
        }
        else
          $this->setAttribut($attr, $user_data[$attr]);
      }
    }

    public function getAttribut($name)
    {
        if($this->existAttribut($name))
            return $_SESSION[$name];
        else
            throw new \Exception("Attribut '$name' absent de la session.");
    }
}
