<?php
namespace App\Reports;
class FundHistoricalNavMemberReportPDF extends \koolreport\KoolReport
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
           $start_date = "";  //date('Y-m-d', strtotime('first day of january last year'));
           $end_date = ""; //date('Y-m-d', strtotime('last day of december this year'));
        return array(
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
            "DISTRIBUTORIDS" => array(0),
        );
    }
    function bindParamsToInputs()
    {
        return array(
          "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
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
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,FUND_PROFILE.FUND_NAME AS FUND_NAME,FUND_PROFILE.FUND_CODE_MEMBER AS FUND_CODE_MEMBER,NAV_LIST.CREATE_TIMESTAMP AS CREATE_TIMESTAMP,NAV_LIST.NAV_SUBMIT_TIMESTAMP AS NAV_SUBMIT_TIMESTAMP,NAV_LIST.NAV_VAL AS NAV_VAL,SETTING_GENERAL.SET_PARAM AS FUND_CURR_DENOMINATION,DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTOR_ID
        from funds_management.NAV_LIST AS NAV_LIST
        JOIN funds_management.FUND_PROFILE AS FUND_PROFILE
        ON FUND_PROFILE.FUND_PROFILE_ID = NAV_LIST.FUND_PROFILE_ID
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = NAV_LIST.DIST_ID 
        LEFT JOIN admin_management.SETTING_GENERAL AS SETTING_GENERAL
        ON SETTING_GENERAL.SETTING_GENERAL_ID = FUND_PROFILE.FUND_CURR_DENOMINATION 
        WHERE 1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and NAV_LIST.DIST_ID in ( :DISTRIBUTOR_ID)":"")."
        ".(( $this->params["dateRange"][0]?"and NAV_LIST.CREATE_TIMESTAMP >= :start":""))."
        ".(( $this->params["dateRange"][1]?"and NAV_LIST.CREATE_TIMESTAMP <= :end":""))." 
         order by NAV_LIST.CREATE_TIMESTAMP desc")
        ->params($query_params)
        ->pipe($this->dataStore("FUNDHISTORICALNAVMEMBEREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));

       

  }
}
