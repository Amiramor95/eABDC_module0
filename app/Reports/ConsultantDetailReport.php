<?php
namespace App\Reports;
use App\Reports\koolsetting;
class ConsultantDetailReport extends ConsultantDetailReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
