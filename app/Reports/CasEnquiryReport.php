<?php
namespace App\Reports;
use App\Reports\koolsetting;

class CasEnquiryReport extends CasEnquiryReportPDF
{
 protected function settings()
  {
    $ks = new koolsetting;
    return $ks->ksetup();
  }
}
