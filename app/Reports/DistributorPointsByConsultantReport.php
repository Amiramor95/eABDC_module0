<?php
namespace App\Reports;
use App\Reports\koolsetting;
class DistributorPointsByConsultantReport extends DistributorPointsByConsultantReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
