<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminCalendarManagementReport extends AdminCalendarManagementReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
