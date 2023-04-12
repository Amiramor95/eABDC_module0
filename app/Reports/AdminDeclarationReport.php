<?php
namespace App\Reports;
use App\Reports\koolsetting;
class AdminDeclarationReport extends AdminDeclarationReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
