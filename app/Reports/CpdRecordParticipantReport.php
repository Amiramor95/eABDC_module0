<?php
namespace App\Reports;
use App\Reports\koolsetting;
class CpdRecordParticipantReport extends CpdRecordParticipantReportPDF
{
    protected function settings()
    {
        $ks = new koolsetting;
        return $ks->ksetup();
    }
}
