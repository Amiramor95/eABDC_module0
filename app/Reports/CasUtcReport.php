<?php
namespace App\Reports;
use App\Reports\koolsetting;
class CasUtcReport extends CasUtcReportPDF
{
  protected function settings()
  {
    $ks = new koolsetting;
    return $ks->ksetup();
  }
}
