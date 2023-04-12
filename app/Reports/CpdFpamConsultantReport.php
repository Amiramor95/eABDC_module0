<?php
namespace App\Reports;
use App\Reports\koolsetting;
class CpdFpamConsultantReport extends CpdFpamConsultantReportPDF
{
  protected function settings()
  {
    $ks = new koolsetting;
    return $ks->ksetup();
  }
}
