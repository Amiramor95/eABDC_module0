<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminAnnouncementManagementReport extends AdminAnnouncementManagementReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
