<?php
namespace App\Reports;
class AdminFeeManagementReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;
    function defaultParamValues()
    {
       // $start_date = date('Y-m-d', strtotime('first day of this month'));
       // $end_date = date('Y-m-d', strtotime('last day of this month'));
        return array(
            // "dateRange"=>array(
            //     $start_date,
            //     $end_date
            // ),
            "MODEID"=>0,
            "CATEGORYID"=>0,
        );
    }
    function bindParamsToInputs()
    {
        return array(
           // "dateRange"=>"dateRange",
           "MODEID",
           "CATEGORYID",
        );
    }


    function setup()
    {
        //var_dump($this->params); echo "<br>";
        if($this->params["MODEID"] == 1){
        $this->src("mysql")
        ->query("Select DISTRIBUTOR_TYPE.DIST_TYPE_NAME AS CATEGORYNAME,DISTRIBUTOR_TYPE.DISTRIBUTOR_TYPE_ID AS CATEGORYID
         from admin_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE")
        ->pipe($this->dataStore("CATEGORYLIST"));
        }
        else{
            $this->src("mysql")
        ->query("Select CONSULTANT_TYPE.TYPE_NAME AS CATEGORYNAME,CONSULTANT_TYPE.CONSULTANT_TYPE_ID AS CATEGORYID
         from admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE")
        ->pipe($this->dataStore("CATEGORYLIST"));
        }


        $query_params = array();
        // if($this->params["MODEID"] != 0)
        // {
        //     $query_params[":MODULE_ID"] = $this->params["MODEID"];
        // }
        if($this->params["CATEGORYID"] != 0)
        {
            $query_params[":CATEGORY_ID"] = $this->params["CATEGORYID"];
        }
        if($this->params["MODEID"] == 1 || $this->params["MODEID"] == 0){
       $this->src("mysql")
       ->query("Select DISTRIBUTOR_FEE.TOTAL_AMOUNT_ANNUAL_FEE AS AMOUNT,DISTRIBUTOR_FEE.FEE_START_DATE AS STARTDATE,DISTRIBUTOR_FEE.FEE_END_DATE AS ENDDATE,DISTRIBUTOR_TYPE.DIST_TYPE_NAME AS CATEGORY
        from admin_management.DISTRIBUTOR_FEE AS DISTRIBUTOR_FEE
        LEFT JOIN admin_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE
           ON DISTRIBUTOR_TYPE.DISTRIBUTOR_TYPE_ID = DISTRIBUTOR_FEE.DIST_TYPE_ID
           WHERE 1=1
           ".(($this->params["CATEGORYID"]!= 0)?"and DISTRIBUTOR_FEE.DIST_TYPE_ID = :CATEGORY_ID ":"")."
       ")
       ->params($query_params)
      ->pipe($this->dataStore("DISTRIBUTORFEEREPORT"));
        }
        if($this->params["MODEID"] == 2 || $this->params["MODEID"] == 0){
      $this->src("mysql")
      ->query("Select CONSULTANT_FEE.TOTAL_AMOUNT_FEE AS AMOUNT,CONSULTANT_FEE.CONS_EFFECTIVE_DATE AS STARTDATE,CONSULTANT_TYPE.TYPE_NAME AS CATEGORY
       from admin_management.CONSULTANT_FEE AS CONSULTANT_FEE
       LEFT JOIN admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE
          ON CONSULTANT_TYPE.CONSULTANT_TYPE_ID = CONSULTANT_FEE.CONSULTANT_TYPE_ID
          WHERE 1=1
          ".(($this->params["CATEGORYID"]!= 0)?"and CONSULTANT_FEE.CONSULTANT_TYPE_ID = :CATEGORY_ID ":"")."
      ")
      ->params($query_params)
     ->pipe($this->dataStore("CONSULTANTFEEREPORT"));
        }
        if($this->params["MODEID"] == 3 || $this->params["MODEID"] == 0){

     $this->src("mysql")
     ->query("Select WAIVER_FEE.TOTAL_AMOUNT_FEE AS AMOUNT,WAIVER_FEE.WAIVER_START_DATE AS STARTDATE,WAIVER_FEE.WAIVER_END_DATE AS ENDDATE,CONSULTANT_TYPE.TYPE_NAME AS CATEGORY
      from admin_management.WAIVER_FEE AS WAIVER_FEE
      LEFT JOIN admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE
         ON CONSULTANT_TYPE.CONSULTANT_TYPE_ID = WAIVER_FEE.CONSULTANT_TYPE_ID
         WHERE 1=1
         ".(($this->params["CATEGORYID"]!= 0)?"and WAIVER_FEE.CONSULTANT_TYPE_ID = :CATEGORY_ID ":"")."
     ")
     ->params($query_params)
    ->pipe($this->dataStore("WAIVERFEEREPORT"));
        }
    }
}
