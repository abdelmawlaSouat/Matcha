<?php
namespace Matcha\Core;

class View
{
  private $_request;
  private $_template;
  private $_nav;
  private $_content;

  const SESSION_TEMPLATE = "userSessionTemplate.php";
  const AUTHENTIFICATION_TEMPLATE = "authentificationTemplate.php";

  public function __construct(Request $request)
  {
    $this->setRequest($request);
    $this->setNav();
    $this->setContent("index");
    $this->setTemplate();
  }

  public function request() { return $this->_request; }
  public function nav() { return $this->_nav; }
  public function content() { return $this->_content; }
  public function template() { return $this->_template; }

  public function setTemplate()
  {
    if (isset($_SESSION["auth"]))
      $this->_template = self::SESSION_TEMPLATE;
    else
      $this->_template = self::AUTHENTIFICATION_TEMPLATE;
  }

  public function setRequest(Request $request)
  {
    if ($request->isValidRequest())
      $this->_request = $request;
  }

  public function setNav($nav_datas = null)
  {
    ob_start();
      require "View/UserSession/Nav/nav.php";
    $this->_nav = ob_get_clean();
  }

  public function setContent($action, $datas = null)
  {
    $array = explode("/", $action);
    if (ucfirst($array[0]) == "Error")
    {
      $file = "View";
      for ($i=0; $i < count($array); $i++)
        $file .= "/". $array[$i];
      $file .= ".php";
    }
    else
    {
      $file = "View/". ucfirst($this->_request->module()) . "/";
      $file .= ucfirst($this->_request->submodule()) . "/";
      $file .= $action . ".php";
    }
    if (file_exists($file))
    {
      ob_start();
        require $file;
      $this->_content = ob_get_clean();
    }
  }

  public function createElement($view, $datas)
  {
    ob_start();
    require $view;
    $content = ob_get_clean();
    return $content;
  }


}
