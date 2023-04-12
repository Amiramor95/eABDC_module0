<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminUserLogReport extends AdminUserLogReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
