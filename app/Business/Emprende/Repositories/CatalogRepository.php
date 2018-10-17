<?php
//Date: 14 May 2018 /
namespace App\Business\Emprende\Repositories;
// bd
use DB;


class CatalogRepository{   

    // public static function fnAllCatalogs(){

    //     $result;
    //     $data = [];
    //     // trae todos los catalogos
    //     $catalogs = DB::table('c_catalogs')->where('typeCatalog','=',"emprende")->get();
      
    //     // recorre los nombres de los catalogos
    //     foreach ($catalogs as $catalog)
    //     {
    //         $name = $catalog->name;
    //         $result= DB::table($name);
    //         //condiciona cuando las tablas son iguales a las establecidas no lleva acabo el where
    //          if($name == 'c_country' || $name == 'c_municipality' || $name == 'c_status' || $name == 'c_state'){
    //            }else{
    //             $result->where('IdStatus','=',1)->select('id', 'name');
    //            }
    //         // llena array  con el nombre del catalogo y su informacion
    //          $data = array_merge($data, [$catalog->name => $result->get()]);
    //     }
    //     return $data;    
    // }	
}