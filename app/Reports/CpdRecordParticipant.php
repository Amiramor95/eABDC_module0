<?php
namespace App\Reports;
use App\Reports\koolsetting;
class CpdRecordParticipant extends \koolreport\KoolReport
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
        ->query("Select PROGRAM.PROG_TITLE AS PROG_TITLE,PROGRAM.PROGRAM_ID AS PROGRAM_ID
         from cpd_management.PROGRAM AS PROGRAM order by PROGRAM_ID asc")
       ->pipe($this->dataStore("RECORDPROGRAM"));
    }
}
