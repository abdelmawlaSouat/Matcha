<?php

namespace Matcha\Core;

class User
{
  private $_id;
  private $_login;
  private $_name;
  private $_firstname;
  private $_email;
  private $_birthdate;
  private $_password;
  private $_gender;
  private $_sexualPreference = NULL;
  private $_biography = NULL;
  private $_tags_array = [];
  private $_pictures = [];
  private $_localisation = NULL;
  private $_fame_rate = 0;
  private $_visits = 0;
  private $_like_counter = 0;
  private $_dislike_counter = 0;
  private $_verified = FALSE;
  private $_token = NULL;

  const MALE = 'male';
  const FEMALE = 'female';
  const OTHER = 'other';

  const HETERO = 'hetero';
  const HOMO = 'homo';
  const BI = 'bi';

  public function __construct(array $data = null) { $this->hydrate($data); }

  /*
  * GETTERS
  */

  public function id() { return ($this->_id); }
  public function login() { return ($this->_login); }
  public function name() { return ($this->_name); }
  public function firstname() { return ($this->_firstname); }
  public function email() { return ($this->_email); }
  public function birthdate() { return ($this->_birthdate); }
  public function password() { return ($this->_password); }
  public function gender() { return ($this->_gender); }
  public function sexualPreference() { return ($this->_sexualPreference); }
  public function biography() { return ($this->_biography); }
  public function tags_array() { return ($this->_tags_array); }
  public function pictures() { return ($this->_pictures); }
  public function localisation() { return ($this->_localisation); }
  public function fame_rate() { return ($this->_fame_rate); }
  public function visits() { return ($this->_visits); }
  public function like_counter() { return ($this->_like_counter); }
  public function dislike_counter() { return ($this->_dislike_counter); }
  public function verified() { return ($this->_verified); }
  public function token() { return ($this->_token); }

  /*
  ** HYDRATATION (premiere fois a la creation de l'instance)
  */

  public function hydrate(array $data = null)
  {
    if (isset($data))
    {
      foreach ($data as $key => $value)
      {
        $method = 'set'.ucfirst($key);
        if (method_exists($this, $method))
          $this->$method($value);
      }
    }
  }

  /*
  * SETTERS
  */

  public function setId($id)
  {
    $id = (int) $id;

    if (!is_int($id) && $id > 0)
    {
      trigger_error('ID must be an integer', E_USER_WARNING);
      return;
    }
    $this->_id = $id;
  }
  public function setLogin($login)
  {
    if (!is_string($login))
    {
      trigger_error('NAME must be a string', E_USER_WARNING);
      return;
    }
    $this->_login = $login;
  }
  public function setName($name)
  {
    if (!is_string($name))
    {
      trigger_error('NAME must be a string', E_USER_WARNING);
      return;
    }
    $this->_name = $name;
  }
  public function setFirstname($firstname)
  {
    if (!is_string($firstname))
    {
      trigger_error('FIRSTNAME must be a string', E_USER_WARNING);
      return;
    }
    $this->_firstname = $firstname;
  }
  public function setEmail($email)
  {
    if (!is_string($email))
    {
      trigger_error('EMAIL must be a string', E_USER_WARNING);
      return;
    }
    $this->_email = $email;
  }
  public function setBirthdate($birthdate)
  {
    if (!is_string($birthdate))
    {
      trigger_error('BIRTHDATE must be a string', E_USER_WARNING);
      return;
    }
    $this->_birthdate = $birthdate;
  }
  public function setPassword($password)
  {
    if (!is_string($password))
    {
      trigger_error('PASSWORD must be a string', E_USER_WARNING);
      return;
    }
    $this->_password = $password;
  }
  public function setGender($gender)
  {
    if (!is_string($gender) && !in_array($gender, [self::MALE, self::FEMALE, self::OTHER]))
    {
      trigger_error('GENDER must be a specific string [male, female or other]', E_USER_WARNING);
      return;
    }
    $this->_gender = $gender;
  }
  public function setSexualpreference($sexualPreference)
  {
    if (!is_string($sexualPreference) && !in_array($sexualPreference, [self::HETERO, self::HOMO, self::BI]))
    {
      trigger_error('SEXUAL PREFERENCE must be a specific string [hetero, homo or bi]', E_USER_WARNING);
      return;
    }
    $this->_sexualPreference = $sexualPreference;
  }
  public function setBiography($biography)
  {
    if (!is_string($biography))
    {
      trigger_error('BIOGRAPHY must be a string', E_USER_WARNING);
      return;
    }
    $this->_biography = $biography;
  }
  public function setTags_array($tags_array)
  {
    if (!is_array($tags_array))
    {
      trigger_error('TAGS ARRAY must be an array', E_USER_WARNING);
      return;
    }
    $this->_tags_array = $tags_array;
  }
  public function setPictures($pictures)
  {
    if (!is_array($pictures))
    {
      trigger_error('PICTURES must be an array', E_USER_WARNING);
      return;
    }
    $this->_pictures = $pictures;
  }
  public function setLocalisation($localisation)
  {
    if (!is_string($localisation))
    {
      trigger_error('LOCALISATION must be a string', E_USER_WARNING);
      return;
    }
    $this->_localisation = $localisation;
  }
  public function setFame_rate($fame_rate)
  {
    if (!is_numeric($fame_rate))
    {
      trigger_error('FAME_RATE must be a number', E_USER_WARNING);
      return;
    }
    $this->_fame_rate = $fame_rate;
  }
  public function setVisits($visits)
  {
    if (!is_int($visits))
    {
      trigger_error('VISITS must be an integer', E_USER_WARNING);
      return;
    }
    $this->_visits = $visits;
  }
  public function setLike_counter($like_counter)
  {
    if (!is_int($like_counter))
    {
      trigger_error('LIKE_COUNTER must be an integer', E_USER_WARNING);
      return;
    }
    $this->_like_counter = $like_counter;
  }
  public function setDislike_counter($dislike_counter)
  {
    if (!is_int($dislike_counter))
    {
      trigger_error('DISLIKE_COUNTER must be an integer', E_USER_WARNING);
      return;
    }
    $this->_dislike_counter = $dislike_counter;
  }
  public function setVerified($verified)
  {
    if (!is_bool($verified))
    {
      trigger_error('VERIFIED must be a boolean', E_USER_WARNING);
      return;
    }
    $this->_verified = $verified;
  }
  public function setToken($token)
  {
    if (!is_int($token))
    {
      trigger_error('TOKEN must be an integer', E_USER_WARNING);
      return;
    }
    $this->_token = $token;
  }

}
