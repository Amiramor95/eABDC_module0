<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FinanceAmsfCollectionReport extends FinanceAmsfCollectionReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
