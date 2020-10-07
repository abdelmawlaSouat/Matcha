<?php

namespace Matcha\Core;

abstract class Model
{
    private static $_db;

    const DSN = "mysql:host=localhost;dbname=matcha;charset=utf8";
    const LOGIN = "root";
    const PASSWD = "root";


    private static function db()
    {
      if(self::$_db === null)
      {
        self::$_db = new \PDO(self::DSN, self::LOGIN, self::PASSWD);
        self::$_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      }

      return self::$_db;
    }


    protected function setDbRequest($req, $params = null)
    {
      if($params == null)
        $result = self::db()->query($req);
      else
      {
        $result = self::db()->prepare($req);
        $result->execute($params);
      }

      return $result;
    }

}
