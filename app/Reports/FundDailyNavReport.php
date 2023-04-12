<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundDailyNavReport extends FundDailyNavReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
