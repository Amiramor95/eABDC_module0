<?php
namespace App\Reports;
use App\Reports\koolsetting;
class ConsultantTerminationSummaryReport extends ConsultantTerminationSummaryReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
