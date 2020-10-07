<?php
namespace Matcha\Controller\UserSession;

use Matcha\Core\SessionController;
use Matcha\Model\UserManager;

class ProfilsSuggestionController extends ProfilsController
{
  public function __construct($request) { parent::__construct($request); }

  public function index()
  {
    $content_datas = array(
      "userCards" => $this->getUserCardByFilters(),
      "interests" => $this->userManager->getAllInterests()
    );

    if (isset($_SESSION["firstConnexion"]) && $this->_accountConfigured() == false)
      $content_datas["alert"] = "./View/Alert/signUp_success.php";
    else if ($this->_accountConfigured() == false)
      $content_datas["alert"] = "./View/Alert/incomplete_user_data.php";

    $this->page->setContent("index", $content_datas);
    parent::index();
  }


  public function getUserCardByFilters()
  {
    $users = [];
    $userCards = [];
    $allUsers = $this->userManager->getAllUsers();
    $ageSlice = explode(" - ", htmlspecialchars($_SESSION["match_preferences"]["ageSlice"]));
    $distance = intval($_SESSION["match_preferences"]["distanceMax"]);
    foreach ($allUsers as $user)
    {
      if ($_SESSION["id"] != $user["id"])
      {
        $match_preferences = json_decode($user["match_preferences"], true);
        $user["match_preferences"] = $match_preferences;

        $validInterestsFilter = $this->validInterestsFilter($user, $_SESSION["interests"]);
        $validAge = $this->validAge($user["birthdate"], $ageSlice);
        $validOrientation = $this->_validOrientation($user["gender"], $ageSlice);
        $validDistance = $distance >= $this->getDistance($user);


        if ($validAge && $validInterestsFilter && $validOrientation && $validDistance)
        {
          $user["avatar"] = explode(", ", $user["pictures"])[0];
          $user["age"] = (new \Datetime($user["birthdate"]))->diff(new \DateTime())->format('%Y');
          $user['distance'] = $this->getDistance($user);
          // print_r($user);
          array_push($users, $user);
        }
      }
    }

    $userCards = $this->getUserCards($users);
    return $userCards;
  }

  private function _validOrientation($userGender)
  {
    if ($_SESSION["match_preferences"]["interessedBy"] == "bi")
      $validOrientation = true;
    else
      $validOrientation = $_SESSION["match_preferences"]["interessedBy"] == $userGender;

    return $validOrientation;
  }


  public function applyFilters()
  { // Pas oublier le score

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
      $usersId = explode(",", htmlspecialchars($_POST["users"]));
      $ageSlice = explode(" - ", htmlspecialchars($_POST["ageSlice"]));
      $scoreSlice = explode(" - ", htmlspecialchars($_POST["scoreSlice"]));
      $distance = htmlspecialchars($_POST["distance"]);
      if (isset($_POST['userFilters']) && $_POST["userFilters"] === true)
        $interests_filter = $_SESSION["interests"];
      else if (!empty($_POST["interests"]))
        $interests_filter = explode(",", htmlspecialchars($_POST["interests"]));

      $users = [];
      foreach ($usersId as $user_id)
      {
        $user = $this->userManager->get("id", $user_id);
        array_push($users, $user);
      }
      foreach ($users as $user)
      {
        if ($_SESSION["id"] != $user["id"])
        {
          $match_preferences = json_decode($user["match_preferences"], true);
          $user["match_preferences"] = $match_preferences;

          $validInterestsFilter = $this->validInterestsFilter($user, $interests_filter);
          $validAge = $this->validAge($user["birthdate"], $ageSlice);
          $validOrientation = $this->_validOrientation($user["gender"], $ageSlice);
          $validDistance = $distance >= $this->getDistance($user);


          if ($validAge && $validInterestsFilter && $validOrientation && $validDistance)
          {
            $user["avatar"] = explode(", ", $user["pictures"])[0];
            $user["age"] = (new \Datetime($user["birthdate"]))->diff(new \DateTime())->format('%Y');
            $user['distance'] = $this->getDistance($user);
            $card = $this->page->createElement("View/UserSession/Profils/profilCard.php", $user);
            echo $card;
          }
        }
      }
    }
  }

}
