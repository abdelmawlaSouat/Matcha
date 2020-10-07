<?php

namespace Matcha\Controller\UserSession;

use Matcha\Core\UserSession;
use Matcha\Core\SessionController;
use Matcha\Model\SeedGeneratorManager;

class SeedGeneratorController extends SessionController
{
  private $_seedGeneratorManager;

  function __construct($request)
  {
    parent::__construct($request);
    $this->setSeedGeneratorManager();
  }

  private function setSeedGeneratorManager()
  {
    $this->_seedGeneratorManager = new SeedGeneratorManager();
  }
  public function getPreciseLocation($location)
  {
    $location = ltrim(rtrim($location));
    $location = str_replace(" ", "+", $location);
    $location = str_replace("-", "+", $location);

    $apiURL = 'http://api.opencagedata.com/geocode/v1/json';
    $apiKey = '6a44fad9e2e442e1b55796ed27cd9c07';
    $requestURL = $apiURL."?key=".$apiKey."&q=".$location."&pretty=1";
    $json = file_get_contents($requestURL);
    $decoded_json = json_decode($json, true);
    $city = "undefined by this free API";
    if ($decoded_json['total_results'] !== 0)
    {
      $latitude = $decoded_json['results'][0]["geometry"]["lat"];
      $longitude = $decoded_json['results'][0]["geometry"]["lng"];
      if (isset($decoded_json['results'][0]["components"]["city"]))
        $city = $decoded_json['results'][0]["components"]["city"];
      $country = $decoded_json['results'][0]["components"]["country"];
      $formatted = $decoded_json['results'][0]["formatted"];
      $reversedLocation = [
        "latitude" => $latitude,
        "longitude" => $longitude,
        "city" => $city,
        "country" => $country,
        "formatted" => $formatted
      ];
      $location = $reversedLocation;

      return ($location);
    }
  }
  public function generate()
  {
    $interessedBy = [
      "male",
      "female",
      "bi"
    ];
    $interests = $this->userManager->getAllInterests();
    $interestLength = count($interests);
    $interestCount = mt_rand(5, 15);
    $interest_array = [];
    $i = 0;
    while ($i < $interestCount)
    {
      $interestIndex = mt_rand(0, ($interestCount - 1));
      if (in_array($interests[$interestIndex]['id'], $interest_array) !== true)
      {
        $interest_array[] = $interests[$interestIndex]['id'];
        $i++;
      }
    }
    $strInterests = implode(", ", $interest_array);
    $i = mt_rand(0, 2);
    // $user = array_walk($_POST['user'], array($this, 'xss_protect'));
    $user = $_POST['user'];
    $location = $this->getPreciseLocation($user["street"]);
    $match_preferences = [
      "location" => $location,
      "interessedBy" => $interessedBy[$i],
      "distanceMax" => "80"
    ];
    $user["interests"] = $strInterests;
    $json_preferences = json_encode($match_preferences);
    $user['$match_preferences'] = $json_preferences;
    $user['password'] = 'qwerty1994';
    $timestamp = mt_rand(1, strtotime('today -18 years'));
    $user['birthdate'] = date('Y-m-d', $timestamp);
    $user['activated'] = 1;
    $this->_seedGeneratorManager->add($user);
  }
}
?>
