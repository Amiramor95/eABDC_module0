<?php
namespace App\Reports;
use App\Reports\koolsetting;

class CasSanctionedReport extends CasSanctionedReportPDF
{
  protected function settings()
  {
    $ks = new koolsetting;
    return $ks->ksetup();
  }
}
