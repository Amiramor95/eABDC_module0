<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfB2FormDistributorReport extends AmsfB2FormDistributorReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
