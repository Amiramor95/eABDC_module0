<?php
namespace App\Reports;
class AdminFinanceCodeReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    function setup()
    {
        $this->src("mysql")
        ->query("Select * from admin_management.FINANCE_ACC_CODE")
       ->pipe($this->dataStore("FINANCECODE"));

       $this->src("mysql")
       ->query("Select FINANCE_CODE.FIN_CODE AS FIN_CODE,DISTRIBUTOR.DIST_NAME AS COMPANY
       from admin_management.FINANCE_CODE AS FINANCE_CODE
       JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
       ON DISTRIBUTOR.DISTRIBUTOR_ID = FINANCE_CODE.DIST_ID
       ")
      ->pipe($this->dataStore("FINANCECOMPANY"));
    }
}
