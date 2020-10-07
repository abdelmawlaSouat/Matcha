<?php

namespace Matcha\Core;

abstract class Controller
{
  protected $request;
  protected $page;

  public function __construct($request)
  {
    $this->setRequest($request);
    $this->setPage();
  }

  public function request() { return $this->request; }
  public function page() { return $this->page; }

  public function setRequest($request)
  {
    $request = new Request($request);
    if ($request->isValidRequest())
      $this->request = $request;
  }

  public function setPage() { $this->page = new View($this->request); }
  public function index() { require "View/". $this->page->template(); }

}

 ?>
