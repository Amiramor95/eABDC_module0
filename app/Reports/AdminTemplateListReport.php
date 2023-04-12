<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminTemplateListReport extends AdminTemplateListReportPDF
{
  protected function settings()
  {
    $ks = new koolsetting;
    return $ks->ksetup();
  }
}
