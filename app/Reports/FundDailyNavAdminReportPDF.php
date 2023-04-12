<?php
namespace App\Reports;
class FundDailyNavAdminReportPDF extends \koolreport\KoolReport
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
            //$start_date =  date('Y-m-d', strtotime('today'));
           //$end_date = date('Y-m-d', strtotime('today'));
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
          //"dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
        // "TSIDS" => "TSIDS",
        // "SCHEMEIDS" => "SCHEMEIDS",
        // "SHARIAH" => "SHARIAH",
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
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,FUND_PROFILE.FUND_NAME AS FUND_NAME,FUND_PROFILE.FUND_PREVIOUS_NAME AS FUND_PREVIOUS_NAME,NAV_LIST.NAV_VAL AS NAV_VAL,NAV_LIST.FUND_NOTES AS FUND_NOTES,SETTING_GENERAL.SET_PARAM AS CURRENCY,NAV_LIST.NAV_SUBMIT_TIMESTAMP AS NAV_SUBMIT_TIMESTAMP,USER.USER_NAME AS UNAME
        from funds_management.NAV_LIST AS NAV_LIST
        JOIN funds_management.FUND_PROFILE AS FUND_PROFILE
        ON FUND_PROFILE.FUND_PROFILE_ID = NAV_LIST.FUND_PROFILE_ID
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = NAV_LIST.DIST_ID
        LEFT JOIN admin_management.SETTING_GENERAL AS SETTING_GENERAL
        ON SETTING_GENERAL.SETTING_GENERAL_ID = FUND_PROFILE.FUND_CURR_DENOMINATION
        LEFT JOIN distributor_management.USER AS USER
        ON USER.USER_ID = NAV_LIST.USER_ID
        WHERE DATE(NAV_LIST.NAV_SUBMIT_TIMESTAMP) = CURDATE()
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and NAV_LIST.DIST_ID in ( :DISTRIBUTOR_ID)":"")."
         order by NAV_LIST.NAV_CREATE_TIMESTAMP desc")
        ->params($query_params)
        ->pipe($this->dataStore("FUNDDAILYNAVADMINREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));
        $this->src("mysql")
        ->query("select FMS_FUNDNOTES.FUNDNOTES_ID AS NO,FMS_FUNDNOTES.FUNDNOTES_DESC AS FUNDNOTES_DESC,FMS_FUNDNOTES.FUND_NOTES_DENOTATION AS FUND_NOTES_DENOTATION
        from admin_management.FMS_FUNDNOTES AS FMS_FUNDNOTES
        ")
        ->pipe($this->dataStore("GLOBALFUNDNOTELIST"));
  }
}
