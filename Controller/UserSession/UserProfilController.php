<?php

namespace Matcha\Controller\UserSession;

use Matcha\Core\SessionController;
use Matcha\Model\UserManager;

class UserProfilController extends SessionController
{
  public function __construct($request) { parent::__construct($request); }

  public function index()
  {
    $datas = array(
      "interests" => $this->userManager->getUserInterests(),
      "age" => (new \Datetime($_SESSION["birthdate"]))->diff(new \DateTime())->format('%Y')
    );

    $this->page->setContent("index", $datas);
    parent::index();
  }

}
