<?php
namespace App\Reports;
class DistributorPointsReportPDF extends \koolreport\KoolReport
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
         //  $start_date = "";//date('Y-m-d', strtotime('first day of this month'));
          // $end_date = "";//date('Y-m-d', strtotime('last day of this month'));
        return array(
            // "dateRange"=>array(
            //     $start_date,
            //     $end_date
            // ),
            "DISTRIBUTORIDS" => array(0),
            "SETTING_GENERAL_ID" => 0,
            "TS_ID" => 0,
        );
    }
    function bindParamsToInputs()
    {
        return array(
         // "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
         "SETTING_GENERAL_ID" => "SETTING_GENERAL_ID",
         "TS_ID" => "TS_ID",
        );
    }
    function setup()
    {
      $query_params = array();
      $query_params1 = array();
      $query_params2 = array();
    //   if(isset($this->params["dateRange"][0]))
    //   {
    //       $query_params[":start"] = $this->params["dateRange"][0];
    //   }
    //   if(isset($this->params["dateRange"][1]))
    //   {
    //       $query_params[":end"] = $this->params["dateRange"][1];
    //   }
    if($this->params["DISTRIBUTORIDS"] != array(0) )
    {
        $query_params[":DISTRIBUTOR_ID"] = $this->params["DISTRIBUTORIDS"];
    }
    if($this->params["SETTING_GENERAL_ID"] != 0)
      {
          $query_params[":GENERAL_ID"] = $this->params["SETTING_GENERAL_ID"];
      }
      if($this->params["TS_ID"] != 0)
      {
          $query_params[":TS_ID"] = $this->params["TS_ID"];
      }
        $this->src("mysql")
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTOR_ID,DISTRIBUTION_POINT.DIST_POINT_NAME AS DIST_POINT_NAME,DISTRIBUTION_POINT.DIST_POINT_CODE AS DIST_POINT_CODE,CONCAT_WS(', ',DISTRIBUTION_POINT.DIST_ADDR_1, DISTRIBUTION_POINT.DIST_ADDR_2,DISTRIBUTION_POINT.DIST_ADDR_3) AS ADDRESS,TASK_STATUS.TS_PARAM AS TS_PARAM,SETTING_POSTAL.POSTCODE_NO AS POSTCODE_NO,CITY.SET_CITY_NAME AS CITYNAME,STATE.SET_PARAM AS STATENAME,DISTRIBUTION_POINT.CREATE_TIMESTAMP AS CREATEDATE,DISTRIBUTION_POINT.LATEST_UPDATE AS LATEST_UPDATE,USER.USER_NAME AS UPDATEDBY,DISTRIBUTION_POINT.DIST_POINT_ID AS DIST_POINT_ID
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        JOIN distributor_management.DISTRIBUTION_POINT AS DISTRIBUTION_POINT
        ON DISTRIBUTION_POINT.DISTRIBUTOR_ID = DISTRIBUTOR.DISTRIBUTOR_ID
        LEFT JOIN admin_management.TASK_STATUS AS TASK_STATUS
        ON TASK_STATUS.TS_ID = DISTRIBUTION_POINT.TS_ID
        LEFT JOIN admin_management.SETTING_POSTAL AS SETTING_POSTAL
        ON SETTING_POSTAL.SETTING_POSTCODE_ID = DISTRIBUTION_POINT.DIST_POSTAL
        LEFT JOIN admin_management.SETTING_CITY AS CITY
        ON CITY.SETTING_CITY_ID = DISTRIBUTION_POINT.DIST_CITY
        LEFT JOIN admin_management.SETTING_GENERAL AS STATE
        ON STATE.SETTING_GENERAL_ID = DISTRIBUTION_POINT.DIST_STATE
        LEFT JOIN distributor_management.USER AS USER
        ON USER.USER_ID = DISTRIBUTION_POINT.CREATE_BY
        WHERE 1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and DISTRIBUTOR.DISTRIBUTOR_ID in ( :DISTRIBUTOR_ID)":"")."
        ".(($this->params["SETTING_GENERAL_ID"]!= 0)?"and DISTRIBUTION_POINT.DIST_STATE = :GENERAL_ID":"")."
        ".(($this->params["TS_ID"]!= 0)?"and DISTRIBUTION_POINT.TS_ID = :TS_ID":"")."
        order by DIST_NAME asc")
        ->params($query_params)
        ->pipe($this->dataStore("CONSULTANTREGISTRATIONSUMMREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR_TYPE.DIST_ID AS DIST_ID,DISTRIBUTORTYPE.DIST_TYPE_NAME AS DIST_TYPE_NAME,DISTRIBUTORTYPE.DISTRIBUTOR_TYPE_ID AS DISTRIBUTOR_TYPE_ID
        from distributor_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE
        LEFT JOIN admin_management.DISTRIBUTOR_TYPE AS DISTRIBUTORTYPE
        ON DISTRIBUTORTYPE.DISTRIBUTOR_TYPE_ID = DISTRIBUTOR_TYPE.DIST_TYPE
        ")
        ->pipe($this->dataStore("DISTRIBUTORTYPE"));

        $this->src("mysql")
        ->query("select CONSULTANT_LICENSE.DIST_POINT_ID AS DIST_POINT_ID,CONSULTANT_LICENSE. 	DISTRIBUTOR_ID AS DISTRIBUTOR_ID
        from consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
        ")
        ->pipe($this->dataStore("CONSULTANTNO"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));
        $this->src("mysql")
        ->query("select STATE.SETTING_GENERAL_ID AS SETTING_GENERAL_ID,STATE.SET_PARAM AS SET_PARAM
        from admin_management.SETTING_GENERAL AS STATE
        where SET_TYPE = 'STATE'
        ")
        ->pipe($this->dataStore("STATELIST"));
        $this->src("mysql")
        ->query("select TASK_STATUS.TS_ID AS TS_ID,TASK_STATUS.TS_PARAM AS TS_PARAM
        from admin_management.TASK_STATUS AS TASK_STATUS
        
        ")
        ->pipe($this->dataStore("STATUSLIST"));

  }
}
