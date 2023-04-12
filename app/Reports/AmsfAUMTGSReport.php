<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfAUMTGSReport extends AmsfAUMTGSReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
