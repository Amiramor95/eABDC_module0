<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundDataSRIReport extends FundDataSRIReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
