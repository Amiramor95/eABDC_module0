<?php
namespace App\Reports;
use App\Reports\koolsetting;
class ConsultantActiveReport extends ConsultantActiveReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
