<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminAddressManagementReport extends AdminAddressManagementReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
