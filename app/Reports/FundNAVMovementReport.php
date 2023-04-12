<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundNAVMovementReport extends FundNAVMovementReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
