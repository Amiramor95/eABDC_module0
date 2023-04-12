<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfTotalSubmissionReport extends AmsfTotalSubmissionReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
