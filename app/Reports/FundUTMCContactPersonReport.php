<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundUTMCContactPersonReport extends FundUTMCContactPersonReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
