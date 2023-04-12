<?php
namespace App\Reports;
use App\Reports\koolsetting;
class ConsultantActiveSummaryReport extends ConsultantActiveSummaryReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
