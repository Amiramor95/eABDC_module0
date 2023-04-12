<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminUserListReport extends AdminUserListReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
