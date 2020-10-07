<?php

namespace Matcha\Core;

class Mail
{
  private $_header = "";
  private $_title = "";
  private $_msg = "";
  private $_key = "";

  public function __construct($title, $msg) { $this->hydrate($title, $msg); }

  public function header() { return $this->_header; }
  public function title() { return $this->_title; }
  public function msg() { return $this->_msg; }
  public function key() { return $this->_key; }

  public function hydrate($title, $msg)
  {
    $this->setHeader();
    $this->setTitle($title);
    $this->setMsg($msg);
    $this->setKey($this->generateKey(8));
  }

  public function setHeader() { $this->_header = "Content-Type:text/html; charset='utf-8'\n"; }
  public function setTitle($title) { $this->_title = $title; }
  public function setMsg($msg) { $this->_msg = $msg; }
  public function setKey($key) { $this->_key = $key; }

  public function generateKey($len)
  {
    $key = "";
    
    for ($i=0; $i < $len; $i++)
    $key .= mt_rand(0, 9);

    return $key;
  }

  public function send($email) { mail($email, $this->title(), $this->msg(), $this->header()); }

}
