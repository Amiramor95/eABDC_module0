<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfSummaryUTMCReport extends AmsfSummaryUTMCReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
