<?php
namespace App\Reports;
use App\Reports\koolsetting;
class DistributorInformationReport extends DistributorInformationReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
