<?php
namespace App\Reports;
class FundAuditTrailReportPDF extends \koolreport\KoolReport
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
        $start_date = date('Y-m-d', strtotime('-2 years'));//date('Y-m-d', strtotime('first day of january last year'));
           $end_date = date('Y-m-d'); //date('Y-m-d', strtotime('last day of december this year'));
        return array(
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
            "DISTRIBUTORIDS" => array(0),
            //"CATEGORYIDS" => array(0),
           // "SCHEMEIDS" => array(0),
           // "SHARIAH" => array(1,2),
        );
    }
    function bindParamsToInputs()
    {
        return array(
          "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
        // "CATEGORYIDS" => "CATEGORYIDS",
        // "SCHEMEIDS" => "SCHEMEIDS",
       //  "SHARIAH" => "SHARIAH",
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
      
        $this->src("mysql")
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,AUDIT_TRAILS.OLD_VALUES AS OLD_VALUES,AUDIT_TRAILS.NEW_VALUES AS NEW_VALUES,AUDIT_TRAILS.UPDATED_AT AS UPDATED_AT,AUDIT_TRAILS.STATUS AS STATUS,USER.USER_NAME AS USER_NAME,USER1.USER_NAME AS USER_NAME1,AUDIT_TRAILS.DIST_ID AS DIST_ID
        from funds_management.AUDIT_TRAILS AS AUDIT_TRAILS
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = AUDIT_TRAILS.DIST_ID
        LEFT JOIN admin_management.USER AS USER
        ON USER.USER_ID = AUDIT_TRAILS.USER_ID
        LEFT JOIN distributor_management.USER AS USER1
        ON USER1.USER_ID = AUDIT_TRAILS.USER_ID
        WHERE 1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and AUDIT_TRAILS.DIST_ID in ( :DISTRIBUTOR_ID)":"")."
        ".(( $this->params["dateRange"][0]?"and AUDIT_TRAILS.UPDATED_AT >= :start":""))."
        ".(( $this->params["dateRange"][1]?"and AUDIT_TRAILS.UPDATED_AT <= :end":""))." 
         order by AUDIT_TRAILS.UPDATED_AT desc")
        ->params($query_params)
        ->pipe($this->dataStore("FUNDAUDITTRAILREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));
  }
}
