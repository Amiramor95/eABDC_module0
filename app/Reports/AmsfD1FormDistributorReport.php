<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfD1FormDistributorReport extends AmsfD1FormDistributorReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
