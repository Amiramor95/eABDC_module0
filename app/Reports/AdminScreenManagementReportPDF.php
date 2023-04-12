<?php
namespace App\Reports;
class AdminScreenManagementReportPDF extends \koolreport\KoolReport
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
            "MANAGEMODULEID"=>0,
            "SUBMANAGEMODULEID"=>0,
        );
    }
    function bindParamsToInputs()
    {
        return array(
           // "dateRange"=>"dateRange",
           "MANAGEMODULEID",
           "SUBMANAGEMODULEID",
        );
    }


    function setup()
    {
        //var_dump($this->params); echo "<br>";
        $this->src("mysql")
        ->query("Select MANAGE_MODULE.MOD_NAME AS MOD_NAME,MANAGE_MODULE.MANAGE_MODULE_ID AS MANAGEMODULEID
         from admin_management.MANAGE_MODULE AS MANAGE_MODULE order by MOD_NAME asc")
        ->pipe($this->dataStore("MODULELIST"));

        $this->src("mysql")
        ->query("Select MANAGE_SUBMODULE.SUBMOD_NAME AS SUBMOD_NAME,MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID AS SUBMANAGEMODULEID
         from admin_management.MANAGE_SUBMODULE AS MANAGE_SUBMODULE
         where MANAGE_SUBMODULE.MANAGE_MODULE_ID = :MODULE_ID
         order by SUBMOD_NAME asc")
         ->params(array(
            ":MODULE_ID"=>$this->params["MANAGEMODULEID"]
        ))
        ->pipe($this->dataStore("SUBMODULELIST"));


        $query_params = array();
        if($this->params["MANAGEMODULEID"] != 0)
        {
            $query_params[":MODULE_ID"] = $this->params["MANAGEMODULEID"];
        }
        if($this->params["SUBMANAGEMODULEID"] != 0)
        {
            $query_params[":SUBMODULE_ID"] = $this->params["SUBMANAGEMODULEID"];
        }

       $this->src("mysql")
       ->query("Select MANAGE_SCREEN.SCREEN_CODE AS SCREEN_CODE,MANAGE_SCREEN.SCREEN_NAME AS SCREEN_NAME,MANAGE_SCREEN.SCREEN_ROUTE AS SCREEN_ROUTE,MANAGE_MODULE.MOD_NAME AS MOD_NAME,MANAGE_SUBMODULE.SUBMOD_NAME AS SUBMOD_NAME,PROCESS_FLOW.PROCESS_FLOW_NAME AS PROCESS_FLOW_NAME
        from admin_management.MANAGE_SCREEN AS MANAGE_SCREEN
        JOIN admin_management.MANAGE_SUBMODULE AS MANAGE_SUBMODULE
           ON MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID = MANAGE_SCREEN.MANAGE_SUBMODULE_ID
        JOIN admin_management.MANAGE_MODULE AS MANAGE_MODULE
           ON MANAGE_MODULE.MANAGE_MODULE_ID = MANAGE_SUBMODULE.MANAGE_MODULE_ID
        LEFT JOIN admin_management.PROCESS_FLOW AS PROCESS_FLOW
           ON PROCESS_FLOW.PROCESS_FLOW_ID = MANAGE_SCREEN.SCREEN_PROCESS
           WHERE 1=1
           ".(($this->params["MANAGEMODULEID"]!= 0)?"and MANAGE_MODULE.MANAGE_MODULE_ID = :MODULE_ID ":"")."
           ".(($this->params["SUBMANAGEMODULEID"]!= 0)?"and MANAGE_SCREEN.MANAGE_SUBMODULE_ID = :SUBMODULE_ID ":"")."
       ")
       ->params($query_params)
      ->pipe($this->dataStore("SCREENREPORT"));
    }
}
