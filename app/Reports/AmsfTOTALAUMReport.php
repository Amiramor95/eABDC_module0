<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfTOTALAUMReport extends AmsfTOTALAUMReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
