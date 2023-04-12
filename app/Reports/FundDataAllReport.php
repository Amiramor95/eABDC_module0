<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundDataAllReport extends FundDataAllReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
