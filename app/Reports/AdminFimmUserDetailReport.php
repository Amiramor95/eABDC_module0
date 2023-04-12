<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminFimmUserDetailReport extends AdminFimmUserDetailReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
