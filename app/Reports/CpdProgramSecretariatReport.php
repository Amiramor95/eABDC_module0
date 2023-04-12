<?php
namespace App\Reports;

use App\Reports\koolsetting;

class CpdProgramSecretariatReport extends CpdProgramSecretariatPDF
{
    protected function settings()
    {
      $ks = new koolsetting;
      return $ks->ksetup();
    }
}
