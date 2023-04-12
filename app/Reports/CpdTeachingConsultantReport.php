<?php
namespace App\Reports;
use App\Reports\koolsetting;
class CpdTeachingConsultantReport extends CpdTeachingConsultantReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
