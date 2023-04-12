<?php
namespace App\Reports;
class AdminTemplateListReportPDF extends \koolreport\KoolReport
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
        );
    }
    function bindParamsToInputs()
    {
        return array(
           // "dateRange"=>"dateRange",
           "MANAGEMODULEID",
        );
    }
    function setup()
    {
        $query_params = array();
        if($this->params["MANAGEMODULEID"] != 0)
        {
            $query_params[":MODULE_ID"] = $this->params["MANAGEMODULEID"];
        }
        $this->src("mysql")
        ->query("Select MANAGE_FORM_TEMPLATE.MANAGE_FORM_TEMPLATE_ID AS MANAGE_FORM_TEMPLATE_ID,MANAGE_FORM_TEMPLATE.TEMP_TITLE AS TEMP_TITLE,MANAGE_FORM_TEMPLATE.TEMP_DESCRIPTION AS TEMP_DESCRIPTION,MANAGE_MODULE.MOD_NAME AS MOD_NAME
        from admin_management.MANAGE_FORM_TEMPLATE AS MANAGE_FORM_TEMPLATE
        JOIN admin_management.MANAGE_MODULE AS MANAGE_MODULE ON MANAGE_MODULE.MANAGE_MODULE_ID = MANAGE_FORM_TEMPLATE.MANAGE_MODULE_ID
        WHERE 1=1
        ".(($this->params["MANAGEMODULEID"]!= 0)?"and MANAGE_FORM_TEMPLATE.MANAGE_MODULE_ID = :MODULE_ID ":"")."
        ")
        ->params($query_params)
       ->pipe($this->dataStore("FORMTEMPLATE"));

       $this->src("mysql")
       ->query("Select MANAGE_MODULE.MOD_NAME AS MOD_NAME,MANAGE_MODULE.MANAGE_MODULE_ID AS MANAGEMODULEID
        from admin_management.MANAGE_MODULE AS MANAGE_MODULE
        order by MOD_NAME asc")
       ->pipe($this->dataStore("MODULELIST"));

    }
}
