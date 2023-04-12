<?php
namespace App\Reports;
class CpdRecordConsultantReportPDF extends \koolreport\KoolReport
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
       ->pipe($this->dataStore("RECORDCONSULTANTREPORT"));

       $this->src("mysql")
       ->query("Select PROGRAM.PROG_TITLE AS TITLE,PROGRAM_DETAILS.PROG_DATE_START AS DATE,DISTRIBUTOR.DIST_NAME AS PROVIDER,PROGRAM_DETAILS.POINT AS CPD_POINT
        from cpd_management.PROGRAM_PARTICIPANT AS PROGRAM_PARTICIPANT
        left join cpd_management.PROGRAM_DETAILS AS PROGRAM_DETAILS ON PROGRAM_DETAILS.PROG_DETAILS_ID = PROGRAM_PARTICIPANT.PROG_DETAILS_ID
        left join cpd_management.PROGRAM AS PROGRAM ON PROGRAM.PROGRAM_ID = PROGRAM_DETAILS.PROGRAM_ID
        left join distributor_management.DISTRIBUTOR AS DISTRIBUTOR ON DISTRIBUTOR.DISTRIBUTOR_ID = PROGRAM.COMPANY_ID AND PROGRAM.CATEGORY =2
       where PROGRAM_PARTICIPANT.CONSULTANT_ID = :CONSULTANT_ID
       ")
        ->params(array(
           ":CONSULTANT_ID"=>$this->params["CID"]
       ))
      ->pipe($this->dataStore("RECORDCONSULTANTREPORTDETAIL"));
    }
}
