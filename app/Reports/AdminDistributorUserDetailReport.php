<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminDistributorUserDetailReport extends AdminDistributorUserDetailReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
