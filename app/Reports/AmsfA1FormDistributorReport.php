<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfA1FormDistributorReport extends AmsfA1FormDistributorReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
