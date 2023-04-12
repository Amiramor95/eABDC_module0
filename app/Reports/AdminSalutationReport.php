<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminSalutationReport extends AdminSalutationReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
