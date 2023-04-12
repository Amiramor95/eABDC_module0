<?php
namespace App\Reports;
use App\Reports\koolsetting;
class DistributorPointsReport extends DistributorPointsReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
