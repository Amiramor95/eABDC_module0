<?php
namespace App\Reports;
use App\Reports\koolsetting;
class CpdRecordConsultantReport extends CpdRecordConsultantReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
