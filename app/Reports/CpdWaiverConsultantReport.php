<?php
namespace App\Reports;
use App\Reports\koolsetting;
class CpdWaiverConsultantReport extends CpdWaiverConsultantReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
