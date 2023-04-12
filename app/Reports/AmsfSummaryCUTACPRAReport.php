<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfSummaryCUTACPRAReport extends AmsfSummaryCUTACPRAReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
