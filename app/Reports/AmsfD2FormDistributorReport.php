<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfD2FormDistributorReport extends AmsfD2FormDistributorReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
