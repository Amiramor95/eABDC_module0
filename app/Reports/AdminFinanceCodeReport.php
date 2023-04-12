<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminFinanceCodeReport extends AdminFinanceCodeReportPDF
{
  protected function settings()
  {
    $ks = new koolsetting;
    return $ks->ksetup();
  }
}
