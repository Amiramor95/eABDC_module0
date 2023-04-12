<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundNewspaperContactReport extends FundNewspaperContactReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
