<?php
/**
 * Created by PhpStorm.
 * User: Bioxor
 * Date: 24/05/2018
 * Time: 04:13 PM
 */

namespace App\Business\Interfaces;


interface PdfRepo
{
    public static function preAuthorizationNegative($id);
    public static function creditApplicationFojalEmprende($id);
    public static function identityOfParticipants($id);
    public static function conditionsOfTheSector($id);
    public static function patrimonialRelationship($id);
    public static function prePositiveAuthorization($id);
    public static function creditBureauAuthorization($id);
}