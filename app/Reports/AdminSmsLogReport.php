<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminSmsLogReport extends AdminSmsLogReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
