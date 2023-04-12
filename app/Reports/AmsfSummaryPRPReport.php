<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfSummaryPRPReport extends AmsfSummaryPRPReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
