<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundDataEPFReport extends FundDataEPFReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
