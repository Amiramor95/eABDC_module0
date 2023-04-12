<?php
namespace App\Reports;
class FundUTMCContactPersonReportPDF extends \koolreport\KoolReport
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
            "COMIDS" => array(0),
            "GROUPIDS" => array(0),
           // "SCHEMEIDS" => array(0),
           // "SHARIAH" => array(1,2),
        );
    }
    function bindParamsToInputs()
    {
        return array(
          //"dateRange"=>"dateRange",
         "COMIDS" => "COMIDS",
         "GROUPIDS" => "GROUPIDS",
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
        // if($this->params["COMIDS"] != array(0) )
        // {
        // $query_params[":COM_ID"] = $this->params["COMIDS"];
        // }
        // if($this->params["GROUPIDS"] != array(0) )
        // {
        // $query_params[":GROUP_ID"] = $this->params["GROUPIDS"];
        // }
        
        $this->src("mysql")
        ->query("Select USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL,USER.USER_MOBILE_NUM AS USER_MOBILE_NUM,USER.USER_OFFICE_NUM AS USER_OFFICE_NUM,SETTING_GENERAL.SET_PARAM AS DESIGNATION
        from distributor_management.USER AS USER
        LEFT JOIN admin_management.SETTING_GENERAL AS SETTING_GENERAL
        ON SETTING_GENERAL.SETTING_GENERAL_ID = USER.USER_SALUTATION
        WHERE USER.USER_GROUP = 4
         ")
       // ->params($query_params)
        ->pipe($this->dataStore("FUNDUTMCCONTACTREPORT"));

        // $this->src("mysql")
        // ->query("select TP_USER_COMPANY.TP_USER_COMP_ID AS COMID,TP_USER_COMPANY.TP_NAME AS TP_NAME
        // from funds_management.TP_USER_COMPANY AS TP_USER_COMPANY
        // ")
        // ->pipe($this->dataStore("ORGANIZATIONLIST"));
        // $this->src("mysql")
        // ->query("select TP_MANAGE_GROUP.TP_MANAGE_GROUP_ID AS GROUPID,TP_MANAGE_GROUP.TP_MANAGE_GROUP_NAME AS GROUPNAME
        // from admin_management.TP_MANAGE_GROUP AS TP_MANAGE_GROUP
        // ")
        // ->pipe($this->dataStore("TPGROUPLIST"));
  }
}
