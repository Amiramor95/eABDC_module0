<?php
namespace App\Reports;
class AdminIDMaskingReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    function setup()
    {
        $this->src("mysql")
        ->query("Select MASKING.MASKING_TYPE AS MASKING_TYPE,MASKING.PREFIX AS PREFIX,MASKING.RUN_NO AS RUN_NO,MASKING.STATUS AS STATUS,MASKING.DESCRIPTION AS DESCRIPTION,MASKING.CREATE_TIMESTAMP AS CREATE_TIMESTAMP,USER.USER_NAME AS NAME
        from admin_management.ID_MASKING_SETTING AS MASKING 
        LEFT JOIN admin_management.USER AS USER ON USER.USER_ID = MASKING.CREATE_BY
        ")
       ->pipe($this->dataStore("IDMASKING"));

    }
}
