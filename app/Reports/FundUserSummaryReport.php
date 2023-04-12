<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundUserSummaryReport extends FundUserSummaryReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
