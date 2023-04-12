<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfA2FormDistributorReport extends AmsfA2FormDistributorReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
