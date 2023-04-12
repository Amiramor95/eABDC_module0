<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminCircularManagementReport extends AdminCircularManagementReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
