<?php
namespace App\Reports;
use App\Reports\koolsetting;
class DistributorPointsConsultantReport extends DistributorPointsConsultantReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
