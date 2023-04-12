<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminFeeManagementReport extends AdminFeeManagementReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
