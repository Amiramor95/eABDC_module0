<?php
namespace App\Reports;
use App\Reports\koolsetting;
class ConsultantBankruptcyReport extends ConsultantBankruptcyReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
