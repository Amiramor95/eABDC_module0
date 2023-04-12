<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfGrossSaleReport extends AmsfGrossSaleReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
