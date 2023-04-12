<?php
namespace App\Reports;
use App\Reports\koolsetting;
class CpdReadingConsultantReport extends CpdReadingConsultantReportPDF
{
    protected function settings()
    {
    $ks = new koolsetting;
    return $ks->ksetup();
    }
}
