<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminSummarySmsLogReport extends AdminSummarySmsLogReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
