<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminUserSummaryReport extends AdminUserSummaryReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
