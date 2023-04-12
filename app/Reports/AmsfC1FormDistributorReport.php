<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfC1FormDistributorReport extends AmsfC1FormDistributorReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
