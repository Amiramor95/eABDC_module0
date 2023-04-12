<?php
namespace App\Reports;
class AdminSalutationReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;
   


    function setup()
    {
        //var_dump($this->params); echo "<br>";
        $this->src("mysql")
        ->query("Select SETTING_GENERAL.SET_PARAM AS SALUTATIONNAME,SETTING_GENERAL.SET_CREATE_BY AS USER,SETTING_GENERAL.SET_CREATE_TIMESTAMP AS DATE
         from admin_management.SETTING_GENERAL AS SETTING_GENERAL where SETTING_GENERAL.SET_TYPE = 'SALUTATION'")
        ->pipe($this->dataStore("SALUTATIONLIST"));
    }
}
