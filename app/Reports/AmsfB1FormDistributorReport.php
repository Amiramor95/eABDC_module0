<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfB1FormDistributorReport extends AmsfB1FormDistributorReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
