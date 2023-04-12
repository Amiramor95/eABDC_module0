<?php
namespace App\Reports;
use App\Reports\koolsetting;
class FundAuditTrailReport extends FundAuditTrailReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
