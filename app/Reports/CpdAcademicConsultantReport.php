<?php
namespace App\Reports;
use App\Reports\koolsetting;
class CpdAcademicConsultantReport extends CpdAcademicConsultantReportPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
