<?php

namespace Matcha\Controller\UserSession;

use Matcha\Core\SessionController;
use Matcha\Core\Image;
use Matcha\Model\UserManager;

class UserSettingsController extends SessionController
{
  public function __construct($request) { parent::__construct($request); }

  public function index()
  {
    $datas = array(
      "interests" => $this->userManager->getAllInterests()
    );
    $this->page->setContent("index", $datas);
    parent::index();
  }

  public function deletePicture()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
      $img_path = htmlspecialchars($_POST["img_path"]);

      $array = explode("/", $img_path);
      $file = end($array);

      $picturesArray = $_SESSION["pictures"];
      $i = array_search($file, $picturesArray);
      if ($_SESSION["avatar"] == $picturesArray[$i])
      {
        $keys = array_keys($picturesArray);
        $j = $keys[1];
        $_SESSION["avatar"] = $picturesArray[$j];
      }
      $picturesArray[$i] = "";
      $picturesArray = array_filter($picturesArray);
      $pictures = implode(", ", $picturesArray);

      $this->userManager->update($_SESSION["id"], "pictures", $pictures);
      $this->userSession()->setAttribut("pictures", $picturesArray);
      unlink($img_path);
    }
  }

  public function addPicture()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
      $srcImgData = array(
        "file" => $_POST["srcImg"],
        "w" => $_POST["srcImg_w"], "h" => $_POST["srcImg_h"]
      );
      $targetData = array(
        "w" => $_POST["target_w"], "h" => $_POST["target_h"],
        "x" => $_POST["target_x"], "y" => $_POST["target_y"]
      );

      $image = new Image($srcImgData, $targetData);
      $imgSrc = $image->imageCreateFromBase64();
      $image->createFinalImg($imgSrc);

      $array = explode("/", $image->finalImage());
      $fileName = end($array);
      $user_data = $this->userManager->get("id", $_SESSION["id"]);

      if (isset($user_data["pictures"][0]))
      {
        $picturesArray = explode(", ", $user_data["pictures"]);
        if (isset($_POST["type_img"]) && $_POST["type_img"] == "avatar")
          array_unshift($picturesArray, $fileName);
        else if (isset($_POST["type_img"]) && $_POST["type_img"] == "picture")
          array_push($picturesArray, $fileName);
        $pictures = implode(", ", $picturesArray);
        $this->userManager->update($_SESSION["id"], "pictures", $pictures);
      }
      else
      {
        $picturesArray = [];
        array_push($picturesArray, $fileName);
        $this->userManager->update($_SESSION["id"], "pictures", $fileName);
      }
      $this->userSession()->setAttribut("pictures", $picturesArray);
      $this->userSession()->setAttribut("avatar", $picturesArray[0]);
    }
  }

  public function sendData()
  {
    if (isset($_POST["update_general_data_btn"]))
    {
      $user_data = array(
        "name" => htmlspecialchars(strtolower($_POST["user_name"])),
        "firstname" => htmlspecialchars(strtolower($_POST["user_firstname"])),
        "email" => htmlspecialchars($_POST["user_email"]),
        "birthdate" => htmlspecialchars($_POST["user_birthday"]),
        "gender" => htmlspecialchars($_POST["user_genre"])
      );
      print_r($user_data);

      $valid_name = preg_match("/^[a-zàéèçù\-]+$/i", $user_data["name"]);
      $valid_firstname = preg_match("/^[a-zàéèçù\-]+$/i", $user_data["firstname"]);
      // $mail_validator = "/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD";
      // $valid_email = preg_match($mail_validator, $user_data["email"]) && $this->userManager()->isFound("email", $user_data["email"]) == 0;

      $today = new \Datetime();
      $_18y = $today->sub(new \DateInterval('P18Y'));
      $birthdate = new \Datetime($user_data["birthdate"]);
      $valid_birthdate = $birthdate <= $_18y;

      echo "1)".$valid_name."
            2)".$valid_firstname."
            3)".$valid_email."
            4)".$valid_birthdate."
      ";

      if ($valid_name && $valid_firstname && $valid_birthdate)
      {
        foreach ($user_data as $key => $value)
        {
          $this->userManager->update($_SESSION["id"], $key, $value);
          $this->userSession()->setAttribut($key, $value);
        }
      }
      else
        echo "Incorrect ! Veuillez vérifier les champs !";
      print_r($_SESSION);
    }
    else if (isset($_POST["update_complem_data_btn"]))
    {
      $user_data = array(
        "job" => htmlspecialchars(strtolower($_POST["user_job"])),
        "bio" => htmlspecialchars(strtolower($_POST["user_bio"])),
        );

      foreach ($user_data as $key => $value)
      {
        $this->userManager->update($_SESSION["id"], $key, $value);
        $this->userSession()->setAttribut($key, $value);
      }
    }
    else if (isset($_POST["update_passwd_btn"]))
    {
      $passwords = array(
        "old" => htmlspecialchars($_POST["old_password"]),
        "new_0" => htmlspecialchars($_POST["new_passwd0"]),
        "new_1" => htmlspecialchars($_POST["new_passwd1"]),
      );

      $user_data = $this->userManager->get("id", $_SESSION["id"]);
      $isOldPasswd = password_verify($passwords["old"], $user_data["password"]);
      $isNewPasswd = $passwords["old"] != $passwords["new_0"];
      $validPasswd = ($passwords["new_0"] === $passwords["new_1"]) && (strlen($passwords["new_0"]) > 7);

      if ($isOldPasswd && $isNewPasswd && $validPasswd)
      {
        $newPasswd = password_hash($passwords["new_0"], PASSWORD_DEFAULT);
        $this->userManager->update($_SESSION["id"], "password", $newPasswd);
      }
      else
        echo "Incorrect ! Veuillez vérifier les champs !";

    }
    else if (isset($_POST["interest_submit"]))
    {
      $interests_array = [];

      $id_interest = htmlspecialchars($_POST["id"]);
      if (isset($_SESSION["interests"][0]))
        $interests_array = $_SESSION["interests"];

      if ($_POST["interest_submit"] == "add")
      {
        array_push($interests_array, $id_interest);
        if (isset($_SESSION["interests"][0]))
          $interests = implode(", ", $interests_array);
        else
          $interests = $id_interest;
      }
      else if ($_POST["interest_submit"] == "remove")
      {
        $i = array_search($id_interest, $interests_array);
        $interests_array[$i] = "";
        $interests_array = array_filter($interests_array);
        $interests = implode(", ", $interests_array);
      }
      $this->userManager->update($_SESSION["id"], "interests", $interests);
      $this->userSession->setAttribut("interests", $interests_array);
    }
    else if (isset($_POST["update_match_settings_btn"]))
    {
      $match_settings = array(
        "location" => htmlspecialchars($_POST["location"]),
        "interessedBy" => htmlspecialchars($_POST["interessedBy"]),
        "distanceMax" => htmlspecialchars($_POST["distanceMax"]),
        "ageSlice" => htmlspecialchars($_POST["ageSlice"]),
      );

      if (!empty($match_settings["location"]))
      {
        $location = ltrim(rtrim($match_settings["location"]));
        $location = str_replace(" ", "+", $location);
        // $location = str_replace("-", "+", $location);
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

          $match_settings["location"] = $reversedLocation;
          $this->userManager->update($_SESSION["id"], "match_preferences", json_encode($match_settings, true));
          $this->userManager->update($_SESSION["id"], "location_status", "changed");
          $this->userSession->setAttribut("match_preferences", $match_settings);
          $this->userSession->setAttribut("location_status", "changed");
        }
        else
          echo "Introuvable ! Veuillez vérifier la localisation !";
      }
      else
        echo "Introuvable ! Veuillez vérifier la localisation !";

    }

  }

}
