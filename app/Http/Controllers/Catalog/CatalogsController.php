<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;

use App\Models\ViewModels\ResposeViewModel;
use App\Http\Responses\Response;

//Models
use App\Models\Catalogs;
use App\Models\Catalogs\cSector;
use App\Models\Catalogs\cScore;
use App\Models\Catalogs\cAccountType;
use App\Models\Catalogs\CAffirmationDenial;
use App\Models\Catalogs\cAnotherCredit;
use App\Models\Catalogs\cBank;
use App\Models\Catalogs\cBusinessPhysicalPerson;
use App\Models\Catalogs\cBusinessType;
use App\Models\Catalogs\cBusinessTypeSAT;
use App\Models\Catalogs\CCivilStatus;
use App\Models\Catalogs\CCountry;
use App\Models\Catalogs\cCustomerType;
use App\Models\Catalogs\cEconomicBacking;
use App\Models\Catalogs\cFunctionalAreas;
use App\Models\Catalogs\CGender;
use App\Models\Catalogs\cGuaranty;
use App\Models\Catalogs\cIdentificationIssuer;
use App\Models\Catalogs\cIdType;
use App\Models\Catalogs\cInternalReference;
use App\Models\Catalogs\CMatrimonialRegime;
use App\Models\Catalogs\cMerchantBusiness;
use App\Models\Catalogs\cMonth;
use App\Models\Catalogs\cMonthExperience;
use App\Models\Catalogs\CMunicipality;
use App\Models\Catalogs\cNationality;
use App\Models\Catalogs\cPersonality;
use App\Models\Catalogs\cProductType;
use App\Models\Catalogs\cProgram;
use App\Models\Catalogs\cProperty;
use App\Models\Catalogs\cRegion;
use App\Models\Catalogs\cRelationship;
use App\Models\Catalogs\cRequestedCredit;
use App\Models\Catalogs\CScholarship;
use App\Models\Catalogs\cShortTerm;
use App\Models\Catalogs\cSISEDECOActivity;
use App\Models\Catalogs\CState;
use App\Models\Catalogs\CStatus;
use App\Models\Catalogs\cTerm;
use App\Models\Catalogs\cTypeCredit;
use App\Models\Catalogs\cTypeLocal;
use App\Models\Catalogs\cUpgrowth;
use App\Models\Catalogs\cYear;
use App\Models\Catalogs\CInformationMedia;
use App\Models\Catalogs\CCapacitationArea;
use App\Models\Catalogs\CFiscalRegime;
use App\Models\Catalogs\COccupation;
use App\Models\Catalogs\CTypeUserType;
use App\Models\Catalogs\CUserType;
use App\Models\Catalogs\cTypePhone;
use App\Models\Catalogs\CAcaSchedule;
//Repositories
use App\Business\Emprende\Repositories\CatalogRepository;
//Queries
use App\Business\Emprende\Queries\CatalogQuery;



/*<bioxor version="CStatus::$ACTIVO">
<casos de uso>
<cu codigo="">Catalogo de emprende</cu>
</casos de uso>
<cambios></cambios>
<info>
	<fecha>07/06/2018</fecha>
<autores>
    <autor>Edewaldo Nuñez</autor>
</autores>
<descripción>
	Esta clase Contiene los servicios para los catalogos de emprende
</descripción>
</info>
</bioxor>
 */
/*
getCatalogs() -> Extrae todos los catalogo de la base de datos.
getCatalogScore() -> Extrae toda la información del catalogo cScores con idStatus Activo.
getCatalogSector() -> Extrae toda la información del catalogo cSector con idStatus Activo.
getCatalogcAccountType() -> Extrae toda la información del catalogo cAccountType (cheque, debito) con idStatus Activo.
getCatalogcAffirmationDenial() -> Extrae toda la información del catalogo cAffirmationDenial con idStatus Activo.
getCatalogcAnotherCredit() -> Extrae toda la información del catalogo cAnotherCredit con idStatus Activo.
getCatalogcBank() -> Extrae toda la información del catalogo cBank etiquetado como activo.
getCatalogcBusinessPhysicalPerson() -> Extrae toda la información del catalogo de c_business_physical_person con idStatus Activo.
getCatalogcBusinessType() -> Extrae toda la información del catalogo de c_business_type_sat con idStatus Activo.
getCatalogcCivilStatus() -> Extrae toda la información del catalogo cCivilStatus con idStatus Activo.
getCatalogcCountry() -> Extrae toda la información del catalogo cCountry  con idStatus Activo.
getCatalogcCustomerType() -> Extrae toda la información del catalogo cCustomerType con idStatus Activo.
getCatalogcBusinessTypeSAT() -> Extrae toda la información del catalogo de cBusinessTypeSAT con idStatus Activo.
getCatalogcEconomicBacking() -> Extrae toda la información del catalogo de economicBacking con idStatus Activo.
getCatalogcFunctionalAreas() -> Extrae toda la información del catalogo de cFunctionalAreas con idStatus Activo.
getCatalogcGender() -> Extrae toda la información del catalogo de cGender con idStatus Activo.   
getCatalogcGuaranty() -> Extrae toda la información del catalogo de cGuaranty con idStatus Activo.
getCatalogcIdentificationIssuer() -> Extrae toda la información del catalogo de indetificationIssuer con idStatus Activo.
getCatalogcIdType() -> Extrae toda la información del catalogo de IdType con idStatus Activo.
getCatalogcInternalReference() -> Extrae toda la información del catalogo de cInternalReference con idStatus Activo.
getCatalogcMatrimonialRegime() -> Extrae toda la información del catalogo de MatrimonialRegime con idStatus Activo.
getCatalogcMerchantBusiness() -> Extrae toda la información del catalogo de MerchantBusiness con idStatus Activo.
getCatalogcMonth() -> Extrae toda la información del catalogo cMonth con idStatus Activo.
getCatalogcMonthExperience() -> Extrae toda la información del catalogo de cMonthExperience con idStatus Activo.
getCatalogcMunicipality() -> Extrae toda la información del catalogo de cMunicipality con idStatus Activo.
getCatalogcNationality() -> Extrae toda la información del catalogo de cNationality con idStatus Activo.
getCatalogcPersonality() -> Extrae toda la información del catalogo de cPersonality con idStatus Activo.
getCatalogcProductType() -> Extrae toda la información del catalogo de cProductType con idStatus Activo.
getCatalogcProgram() -> Extrae toda la información del catalogo de cProgram con idStatus Activo.
getCatalogcProperty() -> Extrae toda la información del catalogo de cProperty con idStatus Activo.
getCatalogcRegime() -> Extrae toda la información del catalogo de cRegime con idStatus Activo.
getCatalogcRegion() -> Extrae toda la información del catalogo de cRegion etiquetados como ctivo.
getCatalogcRelationship() -> Extrae toda la información del catalogo de cRelationship con idStatus Activo.  
getCatalogcRequestedCredit() -> Extrae toda la información del catalogo de cRequestedCredit con idStatus Activo.
getCatalogcScholarship() -> Extrae toda la información del catalogo de cScholarship con idStatus Activo.
getCatalogcShortTerm() -> Extrae toda la información del catalogo de cShortTerm con idStatus Activo.
getCatalogcSISEDECOActivity() -> Extrae toda la información del catalogo de cSISEDECOActivity con idStatus Activo.
getCatalogcState() -> Extrae toda la información del catalogo de cState con idStatus Activo.
getCatalogCStatus() -> Extrae toda la información del catalogo de CStatus etiquetados comoa activo.
getCatalogcTerm() -> Extrae toda la información del catalogo cTerm con idStatus Activo.
getCatalogcTypeCredit() -> Extrae toda la información del catalogo de cTypeCredit con idStatus Activo.
getCatalogcTypeLocal() -> Extrae toda la información del catalogo de cTypeLocal con idStatus Activo.
getCatalogcUpgrowth() -> Extrae toda la información del catalogo de cUpgrowth con idStatus Activo.
getCatalogcYear() -> Extrae toda la información del catalogo de cYear con idStatus Activo.
getCatalagcInformationMedia() -> Extrae toda la información del catalogo de cInformationMedia con idStatus Activo.
getCatalagcCapacitationArea() -> Extrae toda la información del catalogo de CapacitationArea con idStatus Activo.
getCatalagcFiscalRegime() -> Extrae toda la información del catalogo de FiscalRegime con idStatus Activo.
getCatalagcOccupation() -> Extrae toda la información del catalogo de cOccupation con idStatus Activo.
getCatalagcTypeUserType() -> Extrae toda la información del catalogo de cTypeUserType con idStatus Activo.
getCatalagcUserType() -> Extrae toda la información del catalogo de cUserType con idStatus Activo.
getCatalogcAcaTypePhone() -> Extrae toda la información del catalogo de cAcaTypePhone con idStatus Activo. 
*/



class CatalogsController extends Controller
{
    public $oResponse;
    public $oResult;

    public function __construct() 
    {
       $this->oResult = new Response();
    }

    //[HttpGet]
    function getCatalogs()
    {
       
        try{            
            $oResponse = CatalogQuery::fnAllCatalogs();
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 401);
        }
        //return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogScore()
    {
        try
        {            
            $data = cScore::where('idStatus', CStatus::$ACTIVO)->get();
             //$data = CatalogRepository::fnCreateResponseCatalog();
            //Envia la consulta a la tabla como parametro data
            //  $oResponse = $this->oResult->fnResult(null, $data, null);   
            return response()->json($this->oResult->fnResult(true, $data, 'Se ha eviado la información con exito'), 200);    
        
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        //return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);

    }

    //[HttpGet]
    function getCatalogSector()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cSector::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcAccountType()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cAccountType::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    //[HttpGet]
    function getCatalogcAffirmationDenial()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
            $oResponse = cAffirmationDenial::where('idStatus', CStatus::$ACTIVO)->get();    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    //[HttpGet]
    function getCatalogcAnotherCredit()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cAnotherCredit::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    //[HttpGet]
    function getCatalogcBank()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cBank::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    //[HttpGet]
    function getCatalogcBusinessPhysicalPerson()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cBusinessPhysicalPerson::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    //[HttpGet]

    function getCatalogcBusinessType()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cBusinessType::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
   //[HttpGet]
    function getCatalogcBusinessTypeSAT()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cBusinessTypeSAT::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcCivilStatus()
    {
        try{   
            $oResponse = cCivilStatus::where('idStatus', CStatus::$ACTIVO)->get();
            //Envia la consulta a la tabla como parametro data    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcCountry()
    {
        try{   
            $oResponse = CCountry::select('id', 'name')->get();
            //Envia la consulta a la tabla como parametro d;    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcCustomerType()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cCustomerType::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcEconomicBacking()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cEconomicBacking::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    //[HttpGet]
    function getCatalogcFunctionalAreas()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cFunctionalAreas::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    //[HttpGet]
    function getCatalogcGender()
    {

        //extrae toda la informacion del catalogo de generos.

        try{
            $oResponse = CGender::where('idStatus', CStatus::$ACTIVO)->get();
          return response()->json($this->oResult->fnResult(true, $oResponse, 'Se ha eviado la información con exito'), 200);    
        
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
    }

    //[HttpGet]
    function getCatalogcGuaranty()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cGuaranty::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcIdentificationIssuer()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cIdentificationIssuer::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcIdType()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cIdType::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    //[HttpGet]
    function getCatalogcInternalReference()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cInternalReference::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    //[HttpGet]
    function getCatalogcMatrimonialRegime()
    {
        try{   
            $oResponse = CMatrimonialRegime::where('idStatus', CStatus::$ACTIVO)->get();
            //Envia la consulta a la tabla como parametro data
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcMerchantBusiness()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cMerchantBusiness::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcMonth()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cMonth::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

     //[HttpGet]
    function getCatalogcMonthExperience()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cMonthExperience::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    
    /**
     * Método GET para obtener los municipios de un estado seleccionado
     * @method [GET]
     * @return json
     */
    function getCatalogcMunicipality($idState)
    {
        try{ 
            $oResponse = cMunicipality::where('idState',$idState)->orderBy('municipality', 'ASC')->get();
            
            //Envia la consulta a la tabla como parametro data
           //$oResponse = $this->oResult->fnResult(null,cMunicipality::where('idStatus', CStatus::$ACTIVO)->get(),null);    
           return response()->json($this->oResult->fnResult(true, $oResponse, 'Se ha eviado la información con exito'), 200);     
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
    }

    //[HttpGet]
    function getCatalogcNationality()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cNationality::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcPersonality()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cPersonality::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcProductType()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cProductType::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcProgram()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cProgram::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    //[HttpGet]
    function getCatalogcProperty()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cProperty::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcRegime()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cRegime::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcRegion()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cRegion::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    
    //[HttpGet]
    function getCatalogcRelationship()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cRelationship::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    
    //[HttpGet]
    function getCatalogcRequestedCredit()
    {
        try{ 
            $oResponse = cRequestedCredit::where('idStatus', CStatus::$ACTIVO)->get();   
            //Envia la consulta a la tabla como parametro data
           //$oResponse = $this->oResult->fnResult(null,cRequestedCredit::where('idStatus', CStatus::$ACTIVO)->get(),null);    
           return response()->json($this->oResult->fnResult(true, $oResponse, 'Se ha eviado la información con exito'), 200);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
    }

    //[HttpGet]
    function getCatalogcScholarship()
    {
        try{   
            $oResponse = cScholarship::where('idStatus', CStatus::$ACTIVO)->get();
            //Envia la consulta a la tabla como parametro data
          // $oResponse = $this->oResult->fnResult(null,,null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcShortTerm()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cShortTerm::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcSISEDECOActivity()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cSISEDECOActivity::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcState()
    {
        try{   
            $oResponse = cState::where('id', env('STATE_SELECTED'))->get();
            //Envia la consulta a la tabla como parametro data
           //$oResponse = $this->oResult->fnResult(null,cState::all(),null);    
           return response()->json($this->oResult->fnResult(true, $oResponse, 'Se ha eviado la información con exito'), 200);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$err), 400);
        }
    }

    /** */
    function getConfiguratedState(){
        try{
            $oResponse = 'kakaroto';
            return response()->json($this->oResult->fnResult(true,$oResponse,'Se ha enviado la información con éxito'), 200);
        }catch(Exception $e){

            return response()->json($this->oResult->fnResult(false,null,$err), 400);
        }
        
    }

    //[HttpGet]
    function getCatalogCStatus()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,CStatus::where('active', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcTerm()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cStatcTermus::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

     //[HttpGet]
    function getCatalogcTypeCredit()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cTypeCredit::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcTypeLocal()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cTypeLocal::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcUpgrowth()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cUpgrowth::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalogcYear()
    {
        try{   
            //Envia la consulta a la tabla como parametro data
           $oResponse = $this->oResult->fnResult(null,cYear::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalagcInformationMedia()
    {
        try{   
            $oResponse = cInformationMedia::where('idStatus', CStatus::$ACTIVO)->get();
            //Envia la consulta a la tabla como parametro dat    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalagcCapacitationArea()
    {
        try{   
            $oResponse = CCapacitationArea::where('idStatus', CStatus::$ACTIVO)->get();
            //Envia la consulta a la tabla como parametro data
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalagcFiscalRegime()
    {
        try{   
            $oResponse = cFiscalRegime::where('idStatus', CStatus::$ACTIVO)->get();
            //Envia la consulta a la tabla como parametro data    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalagcOccupation()
    {
        try{   
            $oResponse = COccupation::where('idStatus', CStatus::$ACTIVO)->get();
            //Envia la consulta a la tabla como parametro data
           //$oResponse = $this->oResult->fnResult(null,cOccupation::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }

    //[HttpGet]
    function getCatalagcTypeUserType($idUserType)
    {
        try{ 
            $oResponse = cTypeUserType::where('idStatus', CStatus::$ACTIVO)->where('idUserType',$idUserType)->get();
            //Envia la consulta a la tabla como parametro data
           //$oResponse = $this->oResult->fnResult(null,cTypeUserType::where('idStatus', CStatus::$ACTIVO)->get(),null);    
           return response()->json($this->oResult->fnResult(true, $oResponse, 'Se ha eviado la información con exito'), 200);    
        }
        catch(Exception $err){
            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
       // return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    
    //[HttpGet]
    function getCatalagcUserType()
    {
        try{   
            $oResponse = CUserType::where('idStatus', CStatus::$ACTIVO)->get();
            //Envia la consulta a la tabla como parametro data
          // $oResponse = $this->oResult->fnResult(null,cUserType::where('idStatus', CStatus::$ACTIVO)->get(),null);    
          return response()->json($this->oResult->fnResult(true, $oResponse, 'Se ha eviado la información con exito'), 200);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
    }

    function getCatalogcAcaTypePhone()
    {
        try{   
            $oResponse = cTypePhone::select('id', 'name')->get();
            //Envia la consulta a la tabla como parametro data
           //$oResponse = $this->oResult->fnResult(null,CAcaTypePhone::where('idStatus', CStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
    function getCatalogcAcaSchedule()
    {
        try{   
            $oResponse = CAcaSchedule::select('id', 'name')->get();
            //Envia la consulta a la tabla como parametro data
           //$oResponse = $this->oResult->fnResult(null,CAcaTypePhone::where('idStatus', cStatus::$ACTIVO)->get(),null);    
        }
        catch(Exception $err){

            return response()->json($this->oResult->fnResult(false,null,$rr), 400);
        }
        return response()->json($this->oResult->fnResult(true,$oResponse,null), 200);
    }
}
