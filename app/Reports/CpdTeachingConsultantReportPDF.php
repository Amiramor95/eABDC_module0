<?php
namespace App\Reports;
class CpdTeachingConsultantReportPDF extends \koolreport\KoolReport
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
       ->pipe($this->dataStore("TEACHINGCONSULTANTREPORT"));
       $this->src("mysql")
       ->query("Select TEACHING_PARTICIPANT.TEACHING_TITLE AS TITLE,TEACHING_PARTICIPANT.TEACHING_DATE AS DATE,TASK_STATUS.TS_PARAM AS APPROVAL_STATUS ,TEACHING_PARTICIPANT.APPROVE_POINT AS CPD_POINT
        from cpd_management.TEACHING_PARTICIPANT AS TEACHING_PARTICIPANT
        left join cpd_management.TEACHING_APPROVAL AS TEACHING_APPROVAL ON TEACHING_APPROVAL.MODULE_ID = TEACHING_PARTICIPANT.MODULE_ID
        left join admin_management.TASK_STATUS AS TASK_STATUS ON TASK_STATUS.TS_ID = TEACHING_APPROVAL.TS_ID
       where TEACHING_PARTICIPANT.CONSULTANT_ID = :CONSULTANT_ID
       ")
        ->params(array(
           ":CONSULTANT_ID"=>$this->params["CID"]
       ))
      ->pipe($this->dataStore("TEACHINGCONSULTANTREPORTDETAIL"));

      $this->src("mysql")
        ->query("Select CPD_HOURS.CPD_MAX AS CPD_MAX,CPD_HOURS.CPD_HOURS_ID AS CPD_HOURS_ID
         from admin_management.CPD_HOURS AS CPD_HOURS where CPD_HOURS.CPD_PROGRAM_NAME = 'TEACHING' order by CPD_HOURS_ID desc LIMIT 1")
       ->pipe($this->dataStore("TEACHINGAPPROVEMAX"));
    }
}
