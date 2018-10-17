<?php
namespace App\Helpers;


class Helper
{
  public static function ImageToBase64($path){
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
      //dd($base64);
      return $base64;
  }
}
