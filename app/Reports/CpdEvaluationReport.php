<?php
namespace App\Reports;
use App\Reports\koolsetting;
class CpdEvaluationReport extends CpdEvaluationReportPDF
{
  protected function settings()
  {
    $ks = new koolsetting;
    return $ks->ksetup();
  }
}
