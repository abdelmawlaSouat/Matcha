<?php

namespace Matcha\Core;

session_start();

class Routeur
{
  private $_request;
  private $_controller;
  private $_action;

  public function __construct() { $this->hydrate(); }

  public function request() { return $this->_request; }
  public function controller() { return $this->_controller; }
  public function action() { return $this->_action; }

  private function hydrate()
  {
    $this->setRequest();
    $this->setController();
    $this->setAction();
  }

  public function setRequest()
  {
    if (isset($_GET["request"]) && !empty($_GET["request"]))
    {
      $request = htmlspecialchars($_GET["request"]);
      $request_array = explode(".", $request);
      $module = $request_array[0];
      if (isset($module))
      {
        if ($module == "authentification" && isset($_SESSION["auth"]))
          header("Location: index.php?request=userSession.profilsSuggestion.index");
        else if ($module == "userSession" && !isset($_SESSION["auth"]))
          header("Location: index.php?request=authentification.signIn.index");
      }
    }
    else
    {
      if (isset($_SESSION["auth"]))
        header("Location: index.php?request=userSession.profilsSuggestion.index");
      else
        header("Location: index.php?request=authentification.signIn.index");
    }
    $this->_request = new Request($request);
  }

  public function setController()
  {
    if ($this->_request->isValidRequest())
      $this->_controller = ucfirst($this->_request->submodule()) . "Controller";
  }
  public function setAction()
  {
    if ($this->_request->isValidRequest())
    {
      $namespace = "Matcha\Controller\\". ucfirst($this->_request->module()). "\\";
      $class = $namespace . $this->_controller;
      if (method_exists($class, $this->_request->action()))
        $this->_action = $this->_request->action();
    }
  }

  public function executeRequest()
  {
    if ($this->_request->isValidRequest())
    {
      $namespace = "\\Matcha\\Controller\\" . ucfirst($this->_request->module()). "\\";
      $class = $namespace . $this->controller();
      $action = $this->action();
      $request = implode('.', $this->_request->request());
      $controller = new $class($request);
      $controller->$action();
    }
    else
    {
      echo "POPO";
      // $this->page->setContent("error/404");
      // $this->index();
      echo "404 - Page Introuvable";
    }
  }

}
