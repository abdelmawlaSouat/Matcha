<?php
namespace Matcha\Controller\UserSession;

use Matcha\Core\SessionController;
use Matcha\Model\UserManager;

class ProfilsSearchController extends ProfilsController
{
  public function __construct($request) { parent::__construct($request); }

  public function index()
  {
    $datas = array(
      "userCards" => $this->getUserCards(),
      "interests" => $this->userManager->getAllInterests()
    );
    if (isset($_SESSION["firstConnexion"]) && $this->_accountConfigured() == false)
      $datas["alert"] = "./View/Alert/signUp_success.php";
    else if ($this->_accountConfigured() == false)
      $datas["alert"] = "./View/Alert/incomplete_user_data.php";

    $this->page->setContent("index", $datas);
    parent::index();
  }

  private function _validOrientation($orientation, $interessedBy)
  {
    if ($orientation != "all_orientation")
    {
      $validOrientation = false;
      $orientation = explode("_", $orientation)[0];
      if (($interessedBy == $orientation) || ($interessedBy == "bi"))
        $validOrientation =  true;
    }
    else
      $validOrientation = true;

    return $validOrientation;
  }

  private function _validGender($gender, $userGender)
  {
    if ($gender != "both")
    {
      $validGender = false;
      if ($userGender == $gender)
        $validGender =  true;
    }
    else
      $validGender = true;

    return $validGender;
  }

  private function _validOrientation($orientation, $interessedBy)
  {
    if ($orientation != "all_orientation")
    {
      $validOrientation = false;
      $orientation = explode("_", $orientation)[0];
      if (($interessedBy == $orientation) || ($interessedBy == "bi"))
        $validOrientation =  true;
    }
    else
      $validOrientation = true;

    return $validOrientation;
  }

  private function _validGender($gender, $userGender)
  {
    if ($gender != "both")
    {
      $validGender = false;
      if ($userGender == $gender)
        $validGender =  true;
    }
    else
      $validGender = true;

    return $validGender;
  }

  public function applyFilters()
  { // Pas oublier le score

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
      $ageSlice = explode(" - ", htmlspecialchars($_POST["ageSlice"]));
      $scoreSlice = explode(" - ", htmlspecialchars($_POST["scoreSlice"]));
      $distance = htmlspecialchars($_POST["distance"]);
      $orientation = htmlspecialchars($_POST["orientation"]);
      $gender = htmlspecialchars($_POST["gender"]);
      if (!empty($_POST["interests"]))
        $interests_filter = explode(",", htmlspecialchars($_POST["interests"]));

      $allUsers = $this->userManager->getAllUsers();
      foreach ($allUsers as $user)
      {
        if ($_SESSION["id"] != $user["id"])
        {
          $match_preferences = json_decode($user["match_preferences"], true);
          $user["match_preferences"] = $match_preferences;

          $validInterestsFilter = $this->validInterestsFilter($user, $interests_filter);
          $validAge = $this->validAge($user["birthdate"], $ageSlice);
          $validOrientation = $this->_validOrientation($orientation, $match_preferences["interessedBy"]);
          $validGender = $this->_validGender($gender, $user["gender"]);
          $validDistance = $distance >= $this->getDistance($user); //distance

          if ($validAge && $validInterestsFilter && $validOrientation && $validGender && $validDistance)
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
