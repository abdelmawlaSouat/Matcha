<?php

namespace Matcha\Core;

class Request
{
  protected $request_array = array("module" => "", "submodule" => "", "action" => "");
  protected $module = "";
  protected $submodule = "";
  protected $action = "";
  protected $valid_request;

  public function __construct($request) { $this->hydrate($request); }

  private function hydrate($request)
  {
    $this->setRequest($request);
    $this->setModule();
    $this->setSubmodule();
    $this->setAction();
  }

  public function request() { return $this->request_array; }
  public function module() { return $this->module; }
  public function submodule() { return $this->submodule; }
  public function action() { return $this->action; }


  public function isValidRequest()
  {
    $is_Valid = !(empty($this->module())) && !(empty($this->submodule())) &&
                !(empty($this->action()));

    $this->valid_request = $is_Valid;
    return $is_Valid;
  }


  public function setRequest($request)
  {
    if (is_string($request))
    {
      $array = explode(".", $request);
      if (count($array) === 3)
      {
        $request_array = array("module" => $array[0],
                               "submodule" => $array[1],
                               "action" => $array[2]);
        $this->request_array = $request_array;
      }
    }
  }

  public function setModule()
  {
    $path = "./View/". ucfirst($this->request_array["module"]);

    if (file_exists($path))
      $this->module = $this->request_array["module"];
  }

  public function setSubmodule()
  {
    if (!empty($this->module))
    {
      $path = "./View/". ucfirst($this->module) . "/";
      $path .= ucfirst($this->request_array["submodule"]);

      if (file_exists($path))
        $this->submodule = $this->request_array["submodule"];
    }
  }

  public function setAction()
  {
    if (!empty($this->submodule))
    {
      $namespace = "\\Matcha\\Controller\\" . ucfirst($this->module()). "\\";
      $class = $namespace . ucfirst($this->submodule()) . "Controller";
      $action = explode("_", $this->request_array["action"]);
      $action = $action[0];
      if (method_exists($class, $action))
        $this->action = $action;
    }
  }


}

 ?>
