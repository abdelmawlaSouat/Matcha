<?php

namespace Matcha\Controller\UserSession;

use Matcha\Core\SessionController;
use Matcha\Model\UserManager;


class ProfilsController extends SessionController
{

  public function __construct($request) { parent::__construct($request); }

  private function degreesToRadians($degrees)
  {
    return ($degrees * (pi() / 180));
  }
  protected function getDistance($user)
  {
    $userLocation = [
      'latitude' => $_SESSION['match_preferences']['location']['latitude'],
      'longitude' => $_SESSION['match_preferences']['location']['longitude']
    ];
    $suggestionLocation = [
      'latitude' => $user['match_preferences']['location']['latitude'],
      'longitude' > $user['match_preferences']['location']['longitude']
    ];

    $earthRadiusKM = 6371;

    $lat1 = $this->degreesToRadians($suggestionLocation['latitude']);
    $lat2 = $this->degreesToRadians($userLocation['latitude']);

    $dlat = $this->degreesToRadians($userLocation['latitude'] - $suggestionLocation['latitude']);
    $dlon = $this->degreesToRadians($userLocation['longitude'] - $suggestionLocation['longitude']);

    $a = (sin($dlat / 2) * sin($dlat / 2)) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return (round($earthRadiusKM * $c));
  }

  protected function getUserCards($users = null)
  {
    if ($users == null)
    {
      $users = $this->userManager->getAllUsers();
      $searchpage = true;
    }

    $userCards = [];
    foreach ($users as $key => $user)
    {
      if ($_SESSION["id"] != $user["id"])
      {
        if ($searchpage)
        {
          $user["match_preferences"] = json_decode($user["match_preferences"], true);
          $user['distance'] = $this->getDistance($user);
        }
        $user["avatar"] = explode(", ", $user["pictures"])[0];
        $user["age"] = (new \Datetime($user["birthdate"]))->diff(new \DateTime())->format('%Y');;
        $card = $this->page->createElement("View/UserSession/Profils/profilCard.php", $user);
        array_push($userCards, $card);
      }
    }
    return $userCards;
  }

  protected function _accountConfigured()
  {
    $user_data = $this->userManager->get("id", $_SESSION["id"]);
    $dataToVerified = array("birthdate", "gender", "pictures", "interests");

    foreach ($dataToVerified as $key)
    {
      if (!isset($user_data[$key]))
        return false;
    }

    $pictures = explode(", ", $user_data["pictures"]);
    if (count($pictures) == 0 || empty($pictures[0]))
      return false;

    $interests = explode(", ", $user_data["interests"]);
    if (count($interests) < 5)
      return false;

    return true;
  }

  public function showUserProfil()
  {
    $user_data = $this->userManager->get("id", $_POST["id"]);
    $userProfilData = [];

    $sessionData = array(
      "id", "login", "name", "firstname", "birthdate", "job",
      "gender", "match_preferences", "bio", "pictures", "interests"
    );

    for ($i=0; $i < count($sessionData); $i++)
    {
      $attr = $sessionData[$i];

      if ( (($attr == "pictures") || ($attr == "interests")) && !(empty($user_data[$attr])) )
      {
        $array = explode(", ", $user_data[$attr]);
        $userProfilData[$attr] = $array;

        if ($attr == "pictures")
          $userProfilData["avatar"] = $array[0];
      }
      else if ($attr == "match_preferences" && !(empty($user_data[$attr])))
      {
        $matchSettings = json_decode($user_data[$attr], true);
        $userProfilData[$attr] = $matchSettings;
      }
      else
        $userProfilData[$attr] = $user_data[$attr];
    }

    $userProfilData["interests"] = $this->userManager->getUserInterests($userProfilData["interests"]);
    $content = $this->page->createElement("View/UserSession/Profils/userProfil.php", $userProfilData);
    echo $content;
  }

  protected function validInterestsFilter($user, $interests_filter)
  {
    if (isset($interests_filter))
    {
      $userInterests = explode(", ", htmlspecialchars($user["interests"]));
      $validInterestsFilter = false;
      foreach ($interests_filter as $interest)
      {
        if (array_search($interest, $userInterests))
        {
          $validInterestsFilter = true;
          break;
        }
      }
    }
    else
      $validInterestsFilter = true;

    return $validInterestsFilter;
  }

  protected function validAge($birthdate, $ageSlice)
  {
    $userAge = (new \Datetime($birthdate))->diff(new \DateTime())->format('%Y');
    $validAge = $userAge >= $ageSlice[0] && $userAge <= $ageSlice[1];
    return $validAge;
  }

  protected function sortByDefault($a, $b) { return (int)$a["id"] - (int)$b["id"]; }

  protected function sortByAge($a, $b)
  {
    $ageA = (new \Datetime($a["birthdate"]))->diff(new \DateTime())->format('%Y');
    $ageB = (new \Datetime($b["birthdate"]))->diff(new \DateTime())->format('%Y');
    return (int)$ageA - (int)$ageB;
  }

  //Attention pas TESTÉ !!!!!!!
  protected function sortByScore($a, $b) { return (int)$a["score"] - (int)$b["score"]; }

  //Attention pas TESTÉ !!!!!!!
  protected function sortByDistance($a, $b)
  {
    $a["match_preferences"] = json_decode($a["match_preferences"], true);
    $b["match_preferences"] = json_decode($b["match_preferences"], true);
    $distanceA = $this->getDistance($a);
    $distanceB = $this->getDistance($b);
    return (int)$distanceA - (int)$distanceB;
  }

  // Nombre d'occurence d'interets
  protected function getCountOcc($a)
  {
    $userAinterests = explode(",", htmlspecialchars($a["interests"]));
    $countA = 0;
    foreach ($selectedInterests as $interest)
    {
      if (array_search($interest, $userAinterests))
        $countA++;
    }
    return $countA;
  }

  protected function sortByInterests($a, $b)
  {
    $selectedInterests = explode(",", htmlspecialchars($_POST["interestsArray"]));
    $countA = $this->getCountOcc($a);
    $countB = $this->getCountOcc($b);

    return (int)$countA - (int)$countB;
  }

  public function sortProfils()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
      $usersId = explode(",", htmlspecialchars($_POST["users"]));
      $critera = htmlspecialchars($_POST["critera"]);
      $interests = explode(",", htmlspecialchars($_POST["interestsArray"]));

      $users = [];
      foreach ($usersId as $user_id)
      {
        $user = $this->userManager->get("id", $user_id);
        array_push($users, $user);
      }

      if ($critera == "default")
        usort($users, array($this, 'sortByDefault'));
      if ($critera == "age")
        usort($users, array($this, 'sortByAge'));
      else if ($critera == "score")
      {//Attention pas TESTÉ !!!!!!!
        // usort($users, array($this, 'sortByScore'));
      }
      else if ($critera == "distance")
      {
        usort($users, array($this, 'sortByDistance'));
      }
      else if ($critera == "interests")
      {
        if (!empty($_POST["interestsArray"]))
          usort($users, array($this, 'sortByInterests'));
      }

      foreach ($users as $key => $user)
      {
        $user["match_preferences"] = json_decode($user["match_preferences"], true);
        $user["avatar"] = explode(", ", $user["pictures"])[0];
        $user["age"] = (new \Datetime($user["birthdate"]))->diff(new \DateTime())->format('%Y');
        $user['distance'] = $this->getDistance($user);
        $card = $this->page->createElement("View/UserSession/Profils/profilCard.php", $user);
        echo $card;
      }
    }
  }



}
