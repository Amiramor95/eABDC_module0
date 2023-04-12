<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FinancePrcReport extends FinancePrcReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
