<?php

namespace Matcha\Core;

class Image
{
  private $srcImgData;
  private $targetData;
  private $extension;
  private $originalSizeOfSrcImg;
  private $originalSizeOfTarget;
  private $finalImage;

  public function __construct(array $src, array $target)
  {
    $this->setSrcImg($src);
    $this->setTarget($target);
    $this->setOriginalSizeOfSrcImg();
    $this->setOriginalSizeOfTarget();
  }

  public function srcImg () { return $this->srcImgData; }
  public function extension () { return $this->extension; }
  public function target () { return $this->targetData; }
  public function originalSizeOfSrcImg () { return $this->originalSizeOfSrcImg; }
  public function originalSizeOfTarget () { return $this->originalSizeOfTarget; }
  public function finalImage () { return $this->finalImage; }

  public function setSrcImg($src) { $this->srcImgData = $src; }
  public function setExtension($extension) { $this->extension = $extension; }
  public function setTarget($target) { $this->targetData = $target; }
  public function setFinalImage($img) { $this->finalImage = $img;}
  public function setOriginalSizeOfSrcImg()
  {
    $image_size = getimagesize($this->srcImgData["file"]);
    $this->originalSizeOfSrcImg = array(
      "w" => $image_size["0"], "h" => $image_size["1"]
    );
  }

  public function setOriginalSizeOfTarget()
  {
    $w = $this->originalSizeOfSrcImg["w"] * ($this->targetData["w"] / $this->srcImgData["w"]);
    $h = $this->originalSizeOfSrcImg["h"] * ($this->targetData["h"] / $this->srcImgData["h"]);
    $x = $this->originalSizeOfSrcImg["w"] * ($this->targetData["x"] / $this->srcImgData["w"]);
    $y = $this->originalSizeOfSrcImg["h"] * ($this->targetData["y"] / $this->srcImgData["h"]);

    $this->originalSizeOfTarget = array("w" => $w, "h" => $h, "x" => $x, "y" => $y);
  }


  public function imageCreateFromBase64()
  {
    $array = explode(',', $this->srcImgData["file"]);

    // Récupérer l'extension du fichier source
    $array_type = explode("/", $array[0]);
    $array_type = explode(";", $array_type[1]);
    $extension = $array_type[0];
    $this->setExtension($extension);

    // Décode l'image
    $data_64 = str_replace(' ', '+', $array[1]);
    $data = base64_decode($data_64);

    // Créer un fichier img
    $new_file = time() . "." . $extension;
    $imgSrc = "./public/img/" . $new_file;
    file_put_contents($imgSrc, $data);

    return ($imgSrc);
  }

  public function createFinalImg($srcImg)
  {
    if (($this->extension() == "jpeg") || ($this->extension() == "jpg"))
      $img_s = imagecreatefromjpeg($srcImg);
    else if ($this->extension() == "png")
      $img_s = imagecreatefrompng($srcImg);
    else if ($this->extension() == "gif")
      $img_s = imagecreatefromgif($srcImg);

    $img_d = ImageCreateTrueColor(
      $this->originalSizeOfTarget["w"],
      $this->originalSizeOfTarget["h"]
    );

    imagecopyresampled($img_d, $img_s, 0, 0, $this->originalSizeOfTarget["x"],
    $this->originalSizeOfTarget["y"], $this->originalSizeOfTarget["w"],
    $this->originalSizeOfTarget["h"], $this->originalSizeOfTarget["w"],
    $this->originalSizeOfTarget["h"]);

    $folder = "./public/img/users/" . $_SESSION["id"] . "/";
    if (!file_exists($folder))
      mkdir($folder);
    $fileName = $folder . time() . ".jpeg";
    header('Content-type: image/jpeg');
    imagejpeg($img_d, $fileName, 90);
    $this->setFinalImage($fileName);

    unlink($srcImg);

  }

}
