<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundDailyNavAdminReport extends FundDailyNavAdminReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
