<?php
namespace App\Reports;
use App\Reports\koolsetting;
class DistributorTypeSummaryReport extends DistributorTypeSummaryReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
