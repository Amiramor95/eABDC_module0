<?php
namespace App\Reports;
use App\Reports\koolsetting;
class CpdProgramRepeatedReport extends CpdProgramRepeatedReportPDF
{
  protected function settings()
  {
    $ks = new koolsetting;
    return $ks->ksetup();
  }
}
