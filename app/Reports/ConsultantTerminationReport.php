<?php
namespace App\Reports;
use App\Reports\koolsetting;
class ConsultantTerminationReport extends ConsultantTerminationReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
