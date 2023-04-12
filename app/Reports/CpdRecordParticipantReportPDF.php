<?php
namespace App\Reports;
class CpdRecordParticipantReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    function setup()
    {
        $this->src("mysql")
        ->query("Select PROGRAM.PROG_TITLE AS PROG_TITLE,PROGRAM.PROG_CODE AS PROG_CODE,PROGRAM_DETAILS.PROG_DATE_START AS PROG_DATE_START,PROGRAM_DETAILS.POINT AS POINT
         from cpd_management.PROGRAM AS PROGRAM
         left join cpd_management.PROGRAM_DETAILS AS PROGRAM_DETAILS ON PROGRAM_DETAILS.PROGRAM_ID = PROGRAM.PROGRAM_ID
        where PROGRAM.PROGRAM_ID = :PROGRAM_ID")
         ->params(array(
            ":PROGRAM_ID"=>$this->params["CID"]
        ))
       ->pipe($this->dataStore("RECORDPROGRAMREPORT"));

       $this->src("mysql")
       ->query("Select PROGRAM_PARTICIPANT.NAME AS NAME,PROGRAM_PARTICIPANT.NRIC_NUMBER AS NRIC,CONSULTANT.CONSULTANT_FIMM_NO AS FIMM_NO,DISTRIBUTOR.DIST_NAME AS COMPANY,TP_USER_COMPANY.TP_NAME AS COMPANY1,PROGRAM.CATEGORY AS CATEGORY
        from cpd_management.PROGRAM AS PROGRAM
        left join cpd_management.PROGRAM_DETAILS AS PROGRAM_DETAILS ON PROGRAM_DETAILS.PROGRAM_ID = PROGRAM.PROGRAM_ID
        left join cpd_management.PROGRAM_PARTICIPANT AS PROGRAM_PARTICIPANT ON PROGRAM_PARTICIPANT.PROG_DETAILS_ID = PROGRAM_DETAILS.PROG_DETAILS_ID
        left join consultant_management.CONSULTANT AS CONSULTANT ON CONSULTANT.CONSULTANT_ID = PROGRAM_PARTICIPANT.CONSULTANT_ID
        left join distributor_management.DISTRIBUTOR AS DISTRIBUTOR ON DISTRIBUTOR.DISTRIBUTOR_ID = PROGRAM.COMPANY_ID AND  PROGRAM.CATEGORY=2
        left join funds_management.TP_USER_COMPANY AS TP_USER_COMPANY ON TP_USER_COMPANY.TP_USER_COMP_ID = PROGRAM.COMPANY_ID AND  PROGRAM.CATEGORY=3
       where PROGRAM.PROGRAM_ID = :PROGRAM_ID
       ")
        ->params(array(
           ":PROGRAM_ID"=>$this->params["CID"]
       ))
      ->pipe($this->dataStore("RECORDPROGRAMREPORTDETAIL"));
    }
}
