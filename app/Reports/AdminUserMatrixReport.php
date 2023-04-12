<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminUserMatrixReport extends AdminUserMatrixReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
