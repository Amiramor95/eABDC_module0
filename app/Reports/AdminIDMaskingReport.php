<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminIDMaskingReport extends AdminIDMaskingReportPDF
{
  protected function settings()
  {
    $ks = new koolsetting;
    return $ks->ksetup();
  }
}
