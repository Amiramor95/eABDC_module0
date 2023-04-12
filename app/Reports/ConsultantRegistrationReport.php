<?php
namespace App\Reports;
use App\Reports\koolsetting;
class ConsultantRegistrationReport extends ConsultantRegistrationReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
