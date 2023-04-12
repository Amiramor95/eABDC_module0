<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FinanceUtcSummaryReport extends FinanceUtcSummaryReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
