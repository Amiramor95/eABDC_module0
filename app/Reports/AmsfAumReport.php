<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AmsfAumReport extends AmsfAumReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
