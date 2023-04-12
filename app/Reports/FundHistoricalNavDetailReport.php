<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundHistoricalNavDetailReport extends FundHistoricalNavDetailReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
