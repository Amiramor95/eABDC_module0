<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundDataClosedReport extends FundDataClosedReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
