<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfSummaryIUTAReport extends AmsfSummaryIUTAReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
