<?php
namespace App\Reports;
class DistributorPointsByConsultantReportPDF extends \koolreport\KoolReport
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
            "POINTID" => 0,
        );
    }
    function bindParamsToInputs()
    {
        return array(
         // "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
         "SETTING_GENERAL_ID" => "SETTING_GENERAL_ID",
         "POINTID" => "POINTID",
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
      if($this->params["POINTID"] != 0)
      {
          $query_params[":POINT_ID"] = $this->params["POINTID"];
      }
      
        $this->src("mysql")
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTOR_ID,DISTRIBUTION_POINT.DIST_POINT_NAME AS DIST_POINT_NAME,DISTRIBUTION_POINT.DIST_POINT_CODE AS DIST_POINT_CODE,STATE.SET_PARAM AS STATENAME,DISTRIBUTION_POINT.CREATE_TIMESTAMP AS CREATEDATE,DISTRIBUTION_POINT.LATEST_UPDATE AS LATEST_UPDATE,USER.USER_NAME AS UPDATEDBY,DISTRIBUTION_POINT.DIST_POINT_ID AS DIST_POINT_ID,CONSULTANT.CONSULTANT_NAME AS CONSULTANT_NAME,CONSULTANT.CONSULTANT_FIMM_NO AS FIMMNO,CONSULTANT_LICENSE.CONSULTANT_TYPE_ID AS CONSULTANT_TYPE_ID,CONSULTANT_LICENSE.CREATED_AT AS CREATED_AT
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        JOIN distributor_management.DISTRIBUTION_POINT AS DISTRIBUTION_POINT
        ON DISTRIBUTION_POINT.DISTRIBUTOR_ID = DISTRIBUTOR.DISTRIBUTOR_ID
        JOIN consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
        ON CONSULTANT_LICENSE.DIST_POINT_ID = DISTRIBUTION_POINT.DIST_POINT_ID
        JOIN consultant_management.CONSULTANT AS CONSULTANT
        ON CONSULTANT.CONSULTANT_ID = CONSULTANT_LICENSE.CONSULTANT_ID
        LEFT JOIN admin_management.SETTING_GENERAL AS STATE
        ON STATE.SETTING_GENERAL_ID = DISTRIBUTION_POINT.DIST_STATE
        LEFT JOIN distributor_management.USER AS USER
        ON USER.USER_ID = DISTRIBUTION_POINT.CREATE_BY
        WHERE 1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and DISTRIBUTOR.DISTRIBUTOR_ID in ( :DISTRIBUTOR_ID)":"")."
        ".(($this->params["SETTING_GENERAL_ID"]!= 0)?"and DISTRIBUTION_POINT.DIST_STATE = :GENERAL_ID":"")."
        ".(($this->params["POINTID"]!= 0)?"and DISTRIBUTION_POINT.DIST_POINT_ID = :POINT_ID":"")."
        order by DIST_NAME asc")
        ->params($query_params)
        ->pipe($this->dataStore("DISTRIBUTORPOINTBYCONSULTANTREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR_TYPE.DIST_ID AS DIST_ID,DISTRIBUTORTYPE.DIST_TYPE_NAME AS DIST_TYPE_NAME,DISTRIBUTORTYPE.DISTRIBUTOR_TYPE_ID AS DISTRIBUTOR_TYPE_ID
        from distributor_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE
        LEFT JOIN admin_management.DISTRIBUTOR_TYPE AS DISTRIBUTORTYPE
        ON DISTRIBUTORTYPE.DISTRIBUTOR_TYPE_ID = DISTRIBUTOR_TYPE.DIST_TYPE
        ")
        ->pipe($this->dataStore("DISTRIBUTORTYPE"));

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
        ->query("select DISTRIBUTION_POINT.DIST_POINT_ID AS POINTID,DISTRIBUTION_POINT.DIST_POINT_NAME AS POINTNAME
        from distributor_management.DISTRIBUTION_POINT AS DISTRIBUTION_POINT
        ")
        ->pipe($this->dataStore("DISTRIBUTORPOINTLIST"));

  }
}
