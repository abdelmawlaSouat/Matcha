<?php
namespace Matcha\Controller\UserSession;

use Matcha\Core\SessionController;
use Matcha\Model\UserManager;

class LocateController extends SessionController
{
  private $_location;

  public function __construct($request) { parent::__construct($request); }

  public function location()
  {
    return ($this->_location);
  }

  public function setLocation($location)
  {
    $userdata = $this->userManager->get("id", $_SESSION['id']);
    $userdata['match_preferences'] = json_decode($userdata['match_preferences'], true);
    $userdata['match_preferences']['location'] = $location;
    $this->userSession->setAttribut("match_preferences", $userdata['match_preferences']);
    $userdata['match_preferences'] = json_encode($userdata['match_preferences']);
    $this->userManager->update($_SESSION['id'], "match_preferences", $userdata['match_preferences']);
  }

  public function getLocation()
  {
    $json = file_get_contents("http://ip-api.com/json/");
    $json = json_decode($json, true);
    $location = [
      "latitude" => $json['lat'],
      "longitude" => $json['lon'],
      "city" => $json['city'],
      "country" => $json['country'],
      "formatted" => $json['city'].", ".$json['country']
    ];

    return($location);
  }

  public function set()
  {
    $this->userManager->update($_SESSION['id'], "location_status", "default");
    $this->userSession->setAttribut("location_status", "default");
    if (isset($_POST['permission']) && $_POST['permission'] == 'false')
    {
      $this->_location = $this->getLocation();
    }
    else if (isset($_POST['longitude']) && isset($_POST['latitude']))
    {
      $json = file_get_contents("http://www.mapquestapi.com/geocoding/v1/reverse?key=f60svE92dDqVOB32K55xB4g2gJGsAXTc&location=".$_POST['latitude'].",".$_POST['longitude']."");
      $json = json_decode($json, true);
      $this->_location = [
        "latitude" => $_POST['latitude'],
        "longitude" => $_POST['longitude'],
        "city" => $json['results'][0]['locations'][0]['adminArea3'],
        "country" => $_POST['country'],
        "formatted" => $json['results'][0]['locations'][0]['adminArea3'].", ".$_POST['country']
      ];
    }
    $this->setLocation($this->_location);
  }
  public function reset()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
      $this->userManager->update($_SESSION["id"], "location_status", "default");
      $this->userSession->setAttribut("location_status", "default");
    }
  }
}
?>
