<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfSummaryIUTAIPRPReport extends AmsfSummaryIUTAIPRPReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
