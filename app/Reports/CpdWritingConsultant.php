<?php
namespace App\Reports;
use App\Reports\koolsetting;
class CpdWritingConsultant extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
    function setup()
    {
        $this->src("mysql")
        ->query("Select CONSULTANT.CONSULTANT_NAME AS CONSULTANT_NAME,CONSULTANT.CONSULTANT_ID AS CONSULTANT_ID
         from consultant_management.CONSULTANT AS CONSULTANT order by CONSULTANT_ID asc")
       ->pipe($this->dataStore("WRITINGCONSULTANT"));
    }
}
