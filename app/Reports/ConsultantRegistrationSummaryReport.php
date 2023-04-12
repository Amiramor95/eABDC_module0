<?php
namespace App\Reports;
use App\Reports\koolsetting;
class ConsultantRegistrationSummaryReport extends ConsultantRegistrationSummaryReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
