<?php
namespace App\Reports;
use App\Reports\koolsetting;
class DistributorFundLodgementReport extends DistributorFundLodgementReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
