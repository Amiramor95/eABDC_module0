<?php
namespace App\Reports;
class FundDataEPFReportPDF extends \koolreport\KoolReport
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
           // "TSIDS" => array(0),
           // "SCHEMEIDS" => array(0),
           // "SHARIAH" => array(1,2),
        );
    }
    function bindParamsToInputs()
    {
        return array(
         // "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
        // "TSIDS" => "TSIDS",
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
        $this->src("mysql")
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,FUND_PROFILE.FUND_NAME AS FUND_NAME,FUND_PROFILE.FUND_CODE_FIMM AS FUND_CODE_FIMM,FUND_PROFILE.FUND_DATE_LAUNCH AS LAUNCHDATE,FUND_PROFILE.FUND_EPF_CODE AS FUND_EPF_CODE,FUND_PROFILE.FUND_LIPPER_CODE AS FUND_LIPPER_CODE
        from funds_management.FUND_PROFILE AS FUND_PROFILE
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = FUND_PROFILE.DIST_ID
        WHERE FUND_PROFILE.FUND_STATUS_EPF =1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and FUND_PROFILE.DIST_ID in ( :DISTRIBUTOR_ID)":"")."
         order by FUND_PROFILE.FUND_DATE_LAUNCH desc")
        ->params($query_params)
        ->pipe($this->dataStore("FUNDDATAEPFREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));
  }
}
