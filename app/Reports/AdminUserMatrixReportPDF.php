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
          "GROUPIDS" => array(2),
          "MODULEIDS" => array(1,2),
        );
    }
    function bindParamsToInputs()
    {
        return array(
           // "dateRange"=>"dateRange",
           "DEPARTMENTIDS" => "DEPARTMENTIDS",
           "GROUPIDS" => "GROUPIDS",
           "MODULEIDS" => "MODULEIDS",
        );
    }


    function setup()
    {
        //var_dump($this->params); echo "<br>";
        $this->src("mysql")
        ->query(" select MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID AS DEPARTMENTID,MANAGE_DEPARTMENT.DPMT_NAME AS DPMTNAME
        from admin_management.MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT")
        ->pipe($this->dataStore("DEPARTMENTLIST"));
        $this->src("mysql")
        ->query(" select MANAGE_MODULE.MANAGE_MODULE_ID AS MODULEID,MANAGE_MODULE.MOD_SNAME AS MOD_SNAME
        from admin_management.MANAGE_MODULE AS MANAGE_MODULE")
        ->pipe($this->dataStore("MODULELIST"));

        $query_params = array();
        $query_params1 = array();
        $query_params2 = array();
        if($this->params["DEPARTMENTIDS"] != array() )
        {
            $query_params1[":DEPARTMENT_ID"] = $this->params["DEPARTMENTIDS"];
        }
        if($this->params["MODULEIDS"] != array() )
        {
            $query_params2[":MODULE_ID"] = $this->params["MODULEIDS"];
        }
        if($this->params["DEPARTMENTIDS"] != array() )
        {
            $query_params[":DEPARTMENT_ID"] = $this->params["DEPARTMENTIDS"];
        }
        if($this->params["GROUPIDS"] != array())
        {
            $query_params[":GROUP_ID"] = $this->params["GROUPIDS"];
        }

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
       ".(($this->params["MODULEIDS"]!=array())?"and MANAGE_MODULE.MANAGE_MODULE_ID in ( :MODULE_ID)":"")."
       GROUP BY PROCESS_FLOW.PROCESS_FLOW_NAME
       ORDER BY MANAGE_MODULE.MANAGE_MODULE_ID asc")
       ->params($query_params2)
      ->pipe($this->dataStore("USERMATRIXREPORT"));

      $this->src("mysql")
      ->query("Select CONCAT_WS(' => ',MANAGE_GROUP.GROUP_NAME, MANAGE_DEPARTMENT.DPMT_SNAME) AS GD, MANAGE_GROUP.MANAGE_GROUP_ID AS GROUPID,MANAGE_GROUP.GROUP_NAME AS GROUP_NAME,MANAGE_DEPARTMENT.DPMT_SNAME AS SNAME
      from  admin_management.MANAGE_GROUP AS MANAGE_GROUP 
      JOIN admin_management.MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT
      ON MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID = MANAGE_GROUP.MANAGE_DEPARTMENT_ID
      ".(($this->params["DEPARTMENTIDS"]!=array())?"and MANAGE_GROUP.MANAGE_DEPARTMENT_ID in ( :DEPARTMENT_ID)":"")."
      ")
      ->params($query_params1)
     ->pipe($this->dataStore("GROUPLIST"));



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
           ".(($this->params["GROUPIDS"]!=array())?"and MANAGE_GROUP.MANAGE_GROUP_ID in ( :GROUP_ID)":"")."
           ")
           ->params($query_params)
      ->pipe($this->dataStore("USERMATRIXDEPART"));
      $this->src("mysql")
      ->query("Select *
        from admin_management.AUTHORIZATION_LEVEL AS AUTHORIZATION_LEVEL")
     ->pipe($this->dataStore("USERMATRIXAUTHORIZATION"));

    }
}
