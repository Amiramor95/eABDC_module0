<?php
namespace App\Reports;
class FundDataStatusReportPDF extends \koolreport\KoolReport
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
          // $start_date =  "";//date('Y-m-d', strtotime('first day of january last year'));
          // $end_date = ""; //date('Y-m-d', strtotime('last day of december this year'));
        return array(
            // "dateRange"=>array(
            //     $start_date,
            //     $end_date
            // ),
            "DISTRIBUTORIDS" => array(0),
            "TSIDS" => array(0),
           // "SCHEMEIDS" => array(0),
           // "SHARIAH" => array(1,2),
        );
    }
    function bindParamsToInputs()
    {
        return array(
         // "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
         "TSIDS" => "TSIDS",
        // "SCHEMEIDS" => "SCHEMEIDS",
       //  "SHARIAH" => "SHARIAH",
        );
    }
    function setup()
    {
      $query_params = array();
      $query_params1 = array();
      $query_params2 = array();
        // if(isset($this->params["dateRange"][0]))
        // {
        // $query_params[":start"] = $this->params["dateRange"][0];
        // }
        // if(isset($this->params["dateRange"][1]))
        // {
        // $query_params[":end"] = $this->params["dateRange"][1];
        // }
        if($this->params["DISTRIBUTORIDS"] != array(0) )
        {
        $query_params[":DISTRIBUTOR_ID"] = $this->params["DISTRIBUTORIDS"];
        }
        if($this->params["TSIDS"] != array(0) )
        {
        $query_params[":TS_ID"] = $this->params["TSIDS"];
        }
        $this->src("mysql")
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,FUND_PROFILE.FUND_NAME AS FUND_NAME,FUND_PROFILE.FUND_CODE_FIMM AS FUND_CODE_FIMM,FUND_PROFILE.FUND_MATURITY_CLOSURE_DATE AS FUND_MATURITY_CLOSURE_DATE,FUND_PROFILE.FUND_DATE_LAUNCH AS LAUNCHDATE,FUND_PROFILE.FUND_SUSPENSION_DATE AS FUND_SUSPENSION_DATE,TASK_STATUS.TS_PARAM AS TS_PARAM
        from funds_management.FUND_PROFILE AS FUND_PROFILE
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = FUND_PROFILE.DIST_ID
        LEFT JOIN admin_management.TASK_STATUS AS TASK_STATUS
        ON TASK_STATUS.TS_ID = FUND_PROFILE.FUND_STATUS_FUND
        WHERE FUND_PROFILE.FUND_STATUS_FUND IN(22,25,23)
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and FUND_PROFILE.DIST_ID in ( :DISTRIBUTOR_ID)":"")."
        ".(($this->params["TSIDS"]!=array(0))?"and FUND_PROFILE.FUND_STATUS_FUND in ( :TS_ID)":"")."
         order by FUND_PROFILE.FUND_MATURITY_CLOSURE_DATE desc")
        ->params($query_params)
        ->pipe($this->dataStore("FUNDDATASTATUSREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));
        $this->src("mysql")
        ->query("select TASK_STATUS.TS_ID AS TSID,TASK_STATUS.TS_PARAM AS TS_PARAM
        from admin_management.TASK_STATUS AS TASK_STATUS
        WHERE TASK_STATUS.TS_ID IN(22,25,23)
        ")
        ->pipe($this->dataStore("FUNDSTATUSLIST"));
  }
}
