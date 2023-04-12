<?php
namespace App\Reports;
use App\Reports\koolsetting;
class DistributorPreRegBankruptcyReport extends DistributorPreRegBankruptcyReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
