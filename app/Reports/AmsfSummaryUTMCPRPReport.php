<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfSummaryUTMCPRPReport extends AmsfSummaryUTMCPRPReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
