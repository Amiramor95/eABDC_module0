<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminScreenManagementReport extends AdminScreenManagementReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
