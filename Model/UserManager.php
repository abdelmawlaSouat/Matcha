<?php

namespace Matcha\Model;

use Matcha\Core\Model;
use Matcha\Core\User;

class UserManager extends Model
{
  public function isExist($col, $val)
  {
    $sqlReq = "SELECT * FROM users WHERE ". $col ."= ?";
    $req = $this->setDbRequest($sqlReq, array($val));
    $isExist = $req->rowCount();

    return $isExist;
  }

  public function isFound($col, $val)
  {
    $sqlReq = "SELECT * FROM users WHERE ". $col ."= ? AND id <> ?";
    $req = $this->setDbRequest($sqlReq, array($val, $_SESSION["id"]));
    $isExist = $req->rowCount();

    return $isExist;
  }

  public function connect(User $user)
  {
    $sqlReq = "SELECT * FROM users WHERE login = ?";
    $params = array($user->login());
    $req = $this->SetDbRequest($sqlReq, $params);

    $user_data = $req->fetch();
    $foundLogin = $req->rowCount();
    // A TESTER
    // $valid_passwd = $user->password();
    $valid_passwd =
    // password_verify(
      $user->password();
      // , $user_data["password"]);

    return $foundLogin && $valid_passwd;
  }

  public function add($user_data)
  {
    $sqlReq = "INSERT INTO users(login, name, firstname, email, password, match_preferences) VALUES (?,?,?,?,?,?)";
    $params = array(
      $user_data["login"],
      $user_data["name"],
      $user_data["firstname"],
      $user_data["email"],
      $user_data["password"],
      $user_data["match_preferences"]
    );
    $req = $this->setDbRequest($sqlReq, $params);
  }

  public function update($user_id, $col, $val)
  {
    $sqlReq = "UPDATE users SET ". $col ." = ? WHERE id = ?";
    $params = array($val, $user_id);

    $req = $this->SetDbRequest($sqlReq, $params);
  }

  public function get($col, $val)
  {
    $sqlReq = "SELECT * FROM users WHERE ". $col ."= ?";
    $req = $this->setDbRequest($sqlReq, array($val));
    $data = $req->fetch(\PDO::FETCH_ASSOC);

    return $data;
  }

  public function getAllUsers()
  {
    $sqlReq = "SELECT * FROM users";
    $req = $this->setDbRequest($sqlReq);
    $data = $req->fetchAll(\PDO::FETCH_ASSOC);

    return $data;
  }

  public function getSuggestedUsers()
  {
    $sqlReq = "SELECT * FROM users ORDER BY id DESC LIMIT 9";
    $req = $this->setDbRequest($sqlReq);
    $data = $req->fetchAll(\PDO::FETCH_ASSOC);

    return $data;
  }

  public function getAllInterests()
  {
    $sqlReq = "SELECT * FROM interests";
    $req = $this->setDbRequest($sqlReq);
    $data = $req->fetchAll(\PDO::FETCH_ASSOC);

    return $data;
  }

  public function getNumUsers()
  {
    $sqlReq = "SELECT * FROM users ORDER BY id DESC LIMIT 9";
    $req = $this->SetDbRequest($sqlReq);
    $data = $req->fetchALL(\PDO::FETCH_ASSOC);
  }

  public function getUserInterests($interestsId = null)
  {

    if ($interestsId == null)
      $interestsId = $_SESSION["interests"];

    $interests = [];
    if (isset($interestsId))
    {
      foreach ($interestsId as $value)
      {
        $interest = $this->getInterest($value);
        array_push($interests, $interest);
      }
    }
    return $interests;
  }

  public function getInterest($id_interest)
  {
    $sqlReq = "SELECT * FROM interests WHERE id = ". $id_interest;
    $req = $this->setDbRequest($sqlReq);
    $data = $req->fetch(\PDO::FETCH_ASSOC);

    return $data;
  }


}
