<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundHistoricalNavReport extends FundHistoricalNavReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
