<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminConsultantUserDetailReport extends AdminConsultantUserDetailReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
