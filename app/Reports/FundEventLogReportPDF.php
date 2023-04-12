<?php
namespace App\Reports;
class FundEventLogReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;
    //use \koolreport\cloudexport\Exportable;
    function defaultParamValues()
    {
            $start_date = "";// date('Y-m-d', strtotime('today'));
           $end_date = "";//date('Y-m-d', strtotime('today'));
        return array(
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
            "DISTRIBUTORIDS" => array(0),
           // "GROUPIDS" => array(0),
           // "SCHEMEIDS" => array(0),
           // "SHARIAH" => array(1,2),
        );
    }
    function bindParamsToInputs()
    {
        return array(
          "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
        // "GROUPIDS" => "GROUPIDS",
        // "SCHEMEIDS" => "SCHEMEIDS",
        // "SHARIAH" => "SHARIAH",
        );
    }
    function setup()
    {
      $query_params = array();
      $query_params1 = array();
      $query_params2 = array();
        if(isset($this->params["dateRange"][0]))
        {
        $query_params[":start"] = $this->params["dateRange"][0];
        }
        if(isset($this->params["dateRange"][1]))
        {
        $query_params[":end"] = $this->params["dateRange"][1];
        }
        if($this->params["DISTRIBUTORIDS"] != array(0) )
        {
        $query_params[":DISTRIBUTOR_ID"] = $this->params["DISTRIBUTORIDS"];
        }
        // if($this->params["GROUPIDS"] != array(0) )
        // {
        // $query_params[":GROUP_ID"] = $this->params["GROUPIDS"];
        // }
        
        $this->src("mysql")
        ->query("Select AUDIT_TRAILS.CREATED_AT AS CREATED_AT,AUDIT_TRAILS.URL AS SOURCE,AUDIT_TRAILS.EVENT AS ACTION,AUDIT_TRAILS.NEW_VALUES AS DETAIL,USER.USER_NAME AS USER_NAME,DISTRIBUTOR.DIST_NAME AS COMPANY
        from funds_management.AUDIT_TRAILS AS AUDIT_TRAILS
        LEFT JOIN distributor_management.USER AS USER
        ON USER.USER_ID = AUDIT_TRAILS.USER_ID
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = USER.USER_DIST_ID
        WHERE 1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and USER.USER_DIST_ID in ( :DISTRIBUTOR_ID)":"")."
        ".(( $this->params["dateRange"][0]?"and AUDIT_TRAILS.CREATED_AT >= :start":""))."
        ".(( $this->params["dateRange"][1]?"and AUDIT_TRAILS.CREATED_AT <= :end":""))." 
         ")
        ->params($query_params)
        ->pipe($this->dataStore("FUNDEVENTLOGREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));
  
  }
}
