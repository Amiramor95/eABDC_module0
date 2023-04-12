<?php
namespace App\Reports;
class CpdReadingConsultantReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    function setup()
    {
        $this->src("mysql")
        ->query("Select CONSULTANT.CONSULTANT_NAME AS CONSULTANT_NAME,CONSULTANT.CONSULTANT_NRIC AS CONSULTANT_NRIC,CONSULTANT.CONSULTANT_FIMM_NO AS CONSULTANT_FIMM_NO,DISTRIBUTOR.DIST_NAME AS DIST_NAME,CONSULTANT.CONSULTANT_ID AS CONSULTANT_ID
         from consultant_management.CONSULTANT AS CONSULTANT
         left join distributor_management.DISTRIBUTOR AS DISTRIBUTOR ON DISTRIBUTOR.DISTRIBUTOR_ID = CONSULTANT.DISTRIBUTOR_ID
        where CONSULTANT.CONSULTANT_ID = :CONSULTANT_ID")
         ->params(array(
            ":CONSULTANT_ID"=>$this->params["CID"]
        ))
       ->pipe($this->dataStore("READINGCONSULTANTREPORT"));
       $this->src("mysql")
       ->query("Select READING_DETAIL.TITLE AS TITLE,READING_PARTICIPANT.DATE AS DATE,TASK_STATUS.TS_PARAM AS APPROVAL_STATUS ,READING_PARTICIPANT.APPROVE_POINT AS CPD_POINT
        from cpd_management.READING_PARTICIPANT AS READING_PARTICIPANT
        join cpd_management.READING_DETAIL AS READING_DETAIL ON READING_DETAIL.MODULE_ID = READING_PARTICIPANT.MODULE_ID
        left join cpd_management.READING_APPROVAL AS READING_APPROVAL ON READING_APPROVAL.MODULE_ID = READING_PARTICIPANT.MODULE_ID
        left join admin_management.TASK_STATUS AS TASK_STATUS ON TASK_STATUS.TS_ID = READING_APPROVAL.TS_ID
       where READING_PARTICIPANT.CONSULTANT_ID = :CONSULTANT_ID
       ")
        ->params(array(
           ":CONSULTANT_ID"=>$this->params["CID"]
       ))
      ->pipe($this->dataStore("READINGCONSULTANTREPORTDETAIL"));

      $this->src("mysql")
        ->query("Select CPD_HOURS.CPD_MAX AS CPD_MAX,CPD_HOURS.CPD_HOURS_ID AS CPD_HOURS_ID
         from admin_management.CPD_HOURS AS CPD_HOURS where CPD_HOURS.CPD_PROGRAM_NAME = 'READING' order by CPD_HOURS_ID desc LIMIT 1")
       ->pipe($this->dataStore("READINGAPPROVEMAX"));
    }
}
