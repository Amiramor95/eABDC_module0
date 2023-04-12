<?php
namespace App\Reports;
class AdminDeclarationReportPDF extends \koolreport\KoolReport
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
        ->query("Select DECLARATION_SETTING.DECLARATION_SET_TYPE AS SUBMODULE,DECLARATION_SETTING.DECLARATION_SET_PARAM AS MODULE,DECLARATION_SETTING.DECLARATION_DESCRIPTION AS DESCRIPTION,DECLARATION_SETTING.CREATE_TIMESTAMP AS DATE,USER.USER_NAME AS UNAME
         from admin_management.DECLARATION_SETTING AS DECLARATION_SETTING
         LEFT JOIN admin_management.USER AS USER ON USER.USER_ID = DECLARATION_SETTING.CREATE_BY
         ")
        ->pipe($this->dataStore("DECLARATIONLIST"));
    }
}
