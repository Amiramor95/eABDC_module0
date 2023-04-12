<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfC2FormDistributorReport extends AmsfC2FormDistributorReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
