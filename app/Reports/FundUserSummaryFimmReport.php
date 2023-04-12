<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundUserSummaryFimmReport extends FundUserSummaryFimmReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
