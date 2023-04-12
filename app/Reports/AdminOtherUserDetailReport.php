<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminOtherUserDetailReport extends AdminOtherUserDetailReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
