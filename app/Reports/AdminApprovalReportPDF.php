<?php
namespace App\Reports;
class AdminApprovalReportPDF extends \koolreport\KoolReport
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
        //$StartingDate = mktime();
        //$start_date = date('Y-m-d', strtotime('today'));
       // $end_date = date('Y-m-d', strtotime('-1 years'));//date('Y-m-d', strtotime('last day of december this year'));
        return array(
            "MODULEID"=>0,
            "GROUPID"=>0,
            "DEPARTMENTID"=>0,
            "DIVISIONID"=>0,
            // "dateRange"=>array(
            //     $start_date,
            //     $end_date
            // ),
        );
    }
    function bindParamsToInputs()
    {
        return array(
            "MODULEID",
            "GROUPID",
            "DEPARTMENTID",
            "DIVISIONID",
           // "dateRange",
        );
    }
    function setup()
    {
        $query_params = array();
        $query_params1 = array();
        if($this->params["MODULEID"] != 0)
        {
            $query_params[":MODULE_ID"] = $this->params["MODULEID"];
        }
        if($this->params["GROUPID"] != 0)
        {
            $query_params[":GROUP_ID"] = $this->params["GROUPID"];
        }
        if($this->params["DEPARTMENTID"] != 0)
        {
            $query_params[":DEPARTMENT_ID"] = $this->params["DEPARTMENTID"];
        }
        if($this->params["DIVISIONID"] != 0)
        {
            $query_params[":DIVISION_ID"] = $this->params["DIVISIONID"];
        }
        // if(isset($this->params["dateRange"][0]))
        // {
        // $query_params[":start"] = $this->params["dateRange"][0];
        // }
        // if(isset($this->params["dateRange"][1]))
        // {
        // $query_params[":end"] = $this->params["dateRange"][1];
        // }
      
        $this->src("mysql")
        ->query("Select APPROVAL_LEVEL.APPR_LEVEL_NAME AS APPR_LEVEL_NAME,APPROVAL_LEVEL.CREATE_TIMESTAMP AS CREATE_TIMESTAMP,APPROVAL_LEVEL.APPR_STATUS AS APPR_STATUS,PROCESS_FLOW.PROCESS_FLOW_NAME AS PROCESS_FLOW_NAME,MANAGE_MODULE.MOD_NAME AS MOD_NAME,MANAGE_GROUP.GROUP_NAME AS GROUP_NAME,MANAGE_DEPARTMENT.DPMT_NAME AS DPMT_NAME,MANAGE_DIVISION.DIV_NAME AS DIV_NAME
        from admin_management.APPROVAL_LEVEL AS APPROVAL_LEVEL
        JOIN admin_management.PROCESS_FLOW AS PROCESS_FLOW
        ON PROCESS_FLOW.PROCESS_FLOW_ID = APPROVAL_LEVEL.APPR_PROCESSFLOW_ID
        LEFT JOIN admin_management.MANAGE_MODULE AS MANAGE_MODULE
        ON MANAGE_MODULE.MANAGE_MODULE_ID = PROCESS_FLOW.MODULE_ID
        LEFT JOIN admin_management.MANAGE_GROUP AS MANAGE_GROUP
        ON MANAGE_GROUP.MANAGE_GROUP_ID = APPROVAL_LEVEL.APPR_GROUP_ID
        LEFT JOIN admin_management.MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT
        ON MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID = MANAGE_GROUP.MANAGE_DEPARTMENT_ID
        LEFT JOIN admin_management.MANAGE_DIVISION AS MANAGE_DIVISION
        ON MANAGE_DIVISION.MANAGE_DIVISION_ID = MANAGE_DEPARTMENT.MANAGE_DIVISION_ID
        where 1 = 1
        ".(($this->params["MODULEID"]!= 0)?"and MANAGE_MODULE.MANAGE_MODULE_ID = :MODULE_ID":"")."
        ".(($this->params["GROUPID"]!= 0)?"and MANAGE_GROUP.MANAGE_GROUP_ID = :GROUP_ID":"")."
        ".(($this->params["DEPARTMENTID"]!= 0)?"and MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID = :DEPARTMENT_ID":"")."
        ".(($this->params["DIVISIONID"]!= 0)?"and MANAGE_DIVISION.MANAGE_DIVISION_ID = :DIVISION_ID":"")."
         ")
        ->params($query_params)
        ->pipe($this->dataStore("APPROVALREPORT"));
   
   

      $this->src("mysql")
      ->query("select MANAGE_MODULE.MANAGE_MODULE_ID AS MODULEID,MANAGE_MODULE.MOD_SNAME AS MODULENAME
      from admin_management.MANAGE_MODULE AS MANAGE_MODULE
      ")
      ->pipe($this->dataStore("MAINMODULE"));
      $this->src("mysql")
      ->query("select MANAGE_GROUP.MANAGE_GROUP_ID AS GROUPID,MANAGE_GROUP.GROUP_NAME AS GROUP_NAME
      from admin_management.MANAGE_GROUP AS MANAGE_GROUP
      ")
      ->pipe($this->dataStore("MANAGEGROUP"));

      $this->src("mysql")
      ->query("select MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID AS DEPARTMENTID,MANAGE_DEPARTMENT.DPMT_NAME AS DPMT_NAME
      from admin_management.MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT
      ")
      ->pipe($this->dataStore("MANAGEDEPARTMENT"));
      $this->src("mysql")
      ->query("select MANAGE_DIVISION.MANAGE_DIVISION_ID AS DIVISIONID,MANAGE_DIVISION.DIV_NAME AS DIV_NAME
      from admin_management.MANAGE_DIVISION AS MANAGE_DIVISION
      ")
      ->pipe($this->dataStore("MANAGEDIVISION"));
  }
}
