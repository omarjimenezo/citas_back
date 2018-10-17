<?php
namespace App\Business\Interfaces;

interface BaseRepo
{
    public static function fnGet();
    public static function fnFind($id);
    public static function fnSave($oModel);
}