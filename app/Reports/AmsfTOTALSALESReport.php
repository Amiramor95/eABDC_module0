<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfTOTALSALESReport extends AmsfTOTALSALESReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
