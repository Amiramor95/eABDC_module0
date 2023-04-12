<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundDataStatusReport extends FundDataStatusReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
