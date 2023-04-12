<?php
namespace App\Reports;
class FundNAVMovementReportPDF extends \koolreport\KoolReport
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
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,FUND_PROFILE.FUND_NAME_SHORT AS FUND_NAME,FUND_PROFILE.FUND_CODE_FIMM AS FUND_CODE_FIMM,NAV_TEMP_FUND.VALUATION_DATE AS VALUATION_DATE,NAV_LIST.NAV_VAL AS NAV_VAL,NAV_LIST.PREV_NAV_VAL AS PREV_NAV_VAL
        from funds_management.NAV_TEMP_MASTER AS NAV_TEMP_MASTER
        JOIN funds_management.NAV_TEMP_FUND AS NAV_TEMP_FUND
        ON NAV_TEMP_FUND.NAV_TEMP_MASTER_ID = NAV_TEMP_MASTER.NAV_TEMP_MASTER_ID
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = NAV_TEMP_MASTER.DIST_ID
        LEFT JOIN funds_management.FUND_PROFILE AS FUND_PROFILE
        ON FUND_PROFILE.FUND_PROFILE_ID = NAV_TEMP_FUND.FUND_PROFILE_ID
        LEFT JOIN funds_management.NAV_LIST AS NAV_LIST
        ON FUND_PROFILE.FUND_PROFILE_ID = NAV_LIST.FUND_PROFILE_ID
        WHERE 1 = 1
         order by NAV_TEMP_MASTER.LATEST_UPDATE desc")
       // ->params($query_params)
        ->pipe($this->dataStore("FUNDNAVMOVEMENTREPORT"));
       // ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and AUDIT_TRAILS.DIST_ID in ( :DISTRIBUTOR_ID)":"")."
       // ".(( $this->params["dateRange"][0]?"and AUDIT_TRAILS.UPDATED_AT >= :start":""))."
       // ".(( $this->params["dateRange"][1]?"and AUDIT_TRAILS.UPDATED_AT <= :end":""))." 

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));
  }
}
