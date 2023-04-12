<?php
namespace App\Reports;
use App\Reports\koolsetting;

class CasComplainFimm extends CasComplainFimmPDF
{
  protected function settings()
  {
    $ks = new koolsetting;
    return $ks->ksetup();
  }
}
