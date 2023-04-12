<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminApprovalReport extends AdminApprovalReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
