<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FinanceUtcReport extends FinanceUtcReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
