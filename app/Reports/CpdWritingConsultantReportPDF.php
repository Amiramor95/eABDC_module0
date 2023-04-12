<?php
namespace App\Reports;
class CpdWritingConsultantReportPDF extends \koolreport\KoolReport
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
       ->pipe($this->dataStore("WRITINGCONSULTANTREPORT"));

       $this->src("mysql")
       ->query("Select WRITING_PARTICIPANT.WRITING_TITLE AS TITLE,WRITING_PARTICIPANT.PUBLISH_DATE AS DATE,TASK_STATUS.TS_PARAM AS APPROVAL_STATUS,WRITING_PARTICIPANT.APPROVE_POINT AS CPD_POINT
        from cpd_management.WRITING_PARTICIPANT AS WRITING_PARTICIPANT
        left join admin_management.TASK_STATUS AS TASK_STATUS ON TASK_STATUS.TS_ID = WRITING_PARTICIPANT.TS_ID
       where WRITING_PARTICIPANT.CONSULTANT_ID = :CONSULTANT_ID
       ")
        ->params(array(
           ":CONSULTANT_ID"=>$this->params["CID"]
       ))
      ->pipe($this->dataStore("WRITINGCONSULTANTREPORTDETAIL"));

      $this->src("mysql")
        ->query("Select CPD_HOURS.CPD_MIN AS CPD_MIN,CPD_HOURS.CPD_HOURS_ID AS CPD_HOURS_ID
         from admin_management.CPD_HOURS AS CPD_HOURS where CPD_HOURS.CPD_PROGRAM_NAME = 'BOOK' order by CPD_HOURS_ID desc LIMIT 1")
       ->pipe($this->dataStore("BOOKAPPROVEMIN"));
       $this->src("mysql")
       ->query("Select CPD_HOURS.CPD_MIN AS CPD_MIN,CPD_HOURS.CPD_HOURS_ID AS CPD_HOURS_ID
        from admin_management.CPD_HOURS AS CPD_HOURS where CPD_HOURS.CPD_PROGRAM_NAME = 'ARTICLE' order by CPD_HOURS_ID desc LIMIT 1")
      ->pipe($this->dataStore("ARTICLEAPPROVEMIN"));
    }
}
