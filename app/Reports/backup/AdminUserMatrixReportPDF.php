<?php
namespace App\Reports;
class AdminUserMatrixReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;
    function defaultParamValues()
    {
       // $start_date = date('Y-m-d', strtotime('first day of this month'));
       // $end_date = date('Y-m-d', strtotime('last day of this month'));
        return array(
            // "dateRange"=>array(
            //     $start_date,
            //     $end_date
            // ),
          //  "DEPARTMENTID"=>0,
          "DEPARTMENTIDS" => array(1),
           // "STATEID"=>0,
           // "POSTCODEID"=>0,
        );
    }
    function bindParamsToInputs()
    {
        return array(
           // "dateRange"=>"dateRange",
           "DEPARTMENTIDS" => "DEPARTMENTIDS",
          // "STATEID",
          // "POSTCODEID",
        );
    }


    function setup()
    {
        //var_dump($this->params); echo "<br>";
        $this->src("mysql")
        ->query(" select MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID AS DEPARTMENTID,MANAGE_DEPARTMENT.DPMT_NAME AS DPMTNAME
        from admin_management.MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT")
        ->pipe($this->dataStore("DEPARTMENTLIST"));

        $query_params = array();
        if($this->params["DEPARTMENTIDS"] != array() )
        {
            $query_params[":DEPARTMENT_ID"] = $this->params["DEPARTMENTIDS"];
        }
        // if($this->params["STATEID"] != 0)
        // {
        //     $query_params[":STATE_ID"] = $this->params["STATEID"];
        // }
        // if($this->params["POSTCODEID"] != 0)
        // {
        //     $query_params[":POST_ID"] = $this->params["POSTCODEID"];
        // }

        $this->src("mysql")
        ->query("Select MANAGE_MODULE.MANAGE_MODULE_ID AS MANAGE_MODULE_ID,MANAGE_MODULE.MOD_NAME AS MOD_NAME,MANAGE_MODULE.MOD_SNAME AS MOD_SNAME
         from admin_management.MANAGE_MODULE AS MANAGE_MODULE
        ")
       ->pipe($this->dataStore("USERMATRIXMODULE"));

       $this->src("mysql")
       ->query("Select MANAGE_MODULE.MOD_SNAME AS MOD_SNAME,PROCESS_FLOW.PROCESS_FLOW_ID AS PROCESS_FLOW_ID,PROCESS_FLOW.PROCESS_FLOW_NAME AS PROCESS_FLOW_NAME,PROCESS_FLOW.MODULE_ID AS PMUDULEID,MANAGE_SCREEN.MANAGE_SCREEN_ID AS MANAGE_SCREEN_ID 
       from  admin_management.MANAGE_SCREEN AS MANAGE_SCREEN 
       LEFT JOIN admin_management.PROCESS_FLOW AS PROCESS_FLOW 
       ON PROCESS_FLOW.PROCESS_FLOW_ID = MANAGE_SCREEN.SCREEN_PROCESS
       LEFT JOIN admin_management.MANAGE_MODULE AS MANAGE_MODULE
       ON PROCESS_FLOW.MODULE_ID = MANAGE_MODULE.MANAGE_MODULE_ID
       WHERE 1 = 1   
       GROUP BY PROCESS_FLOW.PROCESS_FLOW_NAME 
       ORDER BY MANAGE_MODULE.MANAGE_MODULE_ID asc")
      ->pipe($this->dataStore("USERMATRIXREPORT"));

      //  $this->src("mysql")
      //  ->query("Select MANAGE_MODULE.MOD_SNAME AS MOD_SNAME,PROCESS_FLOW.PROCESS_FLOW_ID AS PROCESS_FLOW_ID,PROCESS_FLOW.PROCESS_FLOW_NAME AS PROCESS_FLOW_NAME,PROCESS_FLOW.MODULE_ID AS PMUDULEID,MANAGE_SCREEN.MANAGE_SCREEN_ID AS MANAGE_SCREEN_ID 
      //  from  admin_management.PROCESS_FLOW AS PROCESS_FLOW 
      //   JOIN admin_management.MANAGE_MODULE AS MANAGE_MODULE
      //  ON PROCESS_FLOW.MODULE_ID = MANAGE_MODULE.MANAGE_MODULE_ID
      //  LEFT JOIN admin_management.MANAGE_SCREEN AS MANAGE_SCREEN
      //      ON PROCESS_FLOW.PROCESS_FLOW_ID = MANAGE_SCREEN.SCREEN_PROCESS
      //      WHERE 1 = 1 ORDER BY MANAGE_MODULE.MANAGE_MODULE_ID asc")
      // ->pipe($this->dataStore("USERMATRIXREPORT"));

      $this->src("mysql")
       ->query("Select AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_NAME AS AUTHORIZATION_LEVEL_NAME,AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_ID AS AUTHORIZATION_LEVEL_ID,MANAGE_SCREEN_ACCESS.MANAGE_GROUP_ID AS MANAGE_GROUP_ID,MANAGE_SCREEN_ACCESS.MANAGE_SCREEN_ID AS MANAGE_SCREEN_ID,MANAGE_SCREEN_ACCESS.USER_ID AS USER_ID,MANAGE_DEPARTMENT.DPMT_NAME AS DPMT_NAME,MANAGE_DEPARTMENT.DPMT_SNAME AS DPMT_SNAME
         from admin_management.MANAGE_SCREEN_ACCESS AS MANAGE_SCREEN_ACCESS
        LEFT JOIN   admin_management.AUTHORIZATION_LEVEL AS AUTHORIZATION_LEVEL
         ON MANAGE_SCREEN_ACCESS.AUTHORIZATION_LEVEL_ID = AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_ID
        LEFT JOIN admin_management.MANAGE_GROUP AS MANAGE_GROUP
         ON MANAGE_GROUP.MANAGE_GROUP_ID = MANAGE_SCREEN_ACCESS.MANAGE_GROUP_ID
         JOIN admin_management.MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT
         ON MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID = MANAGE_GROUP.MANAGE_DEPARTMENT_ID
           ".(($this->params["DEPARTMENTIDS"]!=array())?"and MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID in ( :DEPARTMENT_ID)":"")."
           ")
           ->params($query_params)
      ->pipe($this->dataStore("USERMATRIXDEPART"));
      $this->src("mysql")
      ->query("Select *
        from admin_management.AUTHORIZATION_LEVEL AS AUTHORIZATION_LEVEL")
     ->pipe($this->dataStore("USERMATRIXAUTHORIZATION"));

    }
}
