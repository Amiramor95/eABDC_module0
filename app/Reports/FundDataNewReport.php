<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundDataNewReport extends FundDataNewReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
