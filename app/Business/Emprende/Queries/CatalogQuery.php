<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;
// bd
use DB;


class CatalogQuery{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnAllCatalogs(){

        $result;
        $data = [];
        // trae todos los catalogos
        $catalogs = DB::table('c_catalogs')->where('typeCatalog','=',"emprende")->get();
      
        // recorre los nombres de los catalogos
        foreach ($catalogs as $catalog)
        {
            $name = $catalog->name;
            $result= DB::table($name);
            //condiciona cuando las tablas son iguales a las establecidas no lleva acabo el where
             if($name == 'c_country' || $name == 'c_municipality' || $name == 'c_status' || $name == 'c_state'){
                // obtiene solo los municipios del estado de jalisco.
                if ($name == 'c_municipality' ) 
                      $result->where('idState','=',15)->orderBy('municipality', 'ASC');
                if ($name == 'c_state')
                      $result->where('id','=',15);
                
               }else{
                $result->where('IdStatus','=',1)->select('id', 'name');
               }
            // llena array  con el nombre del catalogo y su informacion
             $data = array_merge($data, [$catalog->name => $result->get()]);
        }
        return $data;    
    }	

    // Forma un solo Json con el catalogo de status
    public static function fnStatusCatalog($id){

        $data = [];
        $data = DB::table('c_status')->where('id','=',$id);
        
        return $data;    
    }	

    // Forma un solo Json con el catalogo de status
    public static function fnTypeCreditCatalog(){

        $data = [];
        $data = DB::table('c_type_credit')->get();
      
        return $data;    
    }	
}