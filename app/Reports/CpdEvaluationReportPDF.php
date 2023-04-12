<?php
namespace App\Reports;
use \koolreport\processes\Join;
class CpdEvaluationReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    function setup()
    {
         $this->src("mysql")
        ->query("Select  DISTRIBUTOR.DIST_NAME AS COMPANY,TP_USER_COMPANY.TP_NAME AS COMPANY1,PROGRAM.PROG_CODE AS PROG_CODE,PROGRAM.PROG_TITLE AS PROG_TITLE,PROGRAM_DETAILS.PROG_DATE_START AS PROG_DATE_START,PROGRAM_DETAILS.PROG_VENUE AS VENUE,PROGRAM_DETAILS.PROG_DETAILS_ID AS PROG_DETAILS_ID,PROGRAM_SLO.SPEAKER AS SPEAKER,PROGRAM.CATEGORY AS CATEGORY
         from cpd_management.PROGRAM AS PROGRAM
          join cpd_management.PROGRAM_DETAILS AS PROGRAM_DETAILS ON PROGRAM_DETAILS.PROGRAM_ID = PROGRAM.PROGRAM_ID 
          left join distributor_management.DISTRIBUTOR AS DISTRIBUTOR ON DISTRIBUTOR.DISTRIBUTOR_ID = PROGRAM.COMPANY_ID AND PROGRAM.CATEGORY = 2
         left join funds_management.TP_USER_COMPANY AS TP_USER_COMPANY ON TP_USER_COMPANY.TP_USER_COMP_ID = PROGRAM.COMPANY_ID AND PROGRAM.CATEGORY = 3
          left join cpd_management.PROGRAM_SLO AS PROGRAM_SLO ON PROGRAM_SLO.PROG_DETAILS_ID = PROGRAM_DETAILS. 	PROG_DETAILS_ID
         where PROGRAM.CATEGORY IN(2,3)
         order by PROGRAM_DETAILS.PROG_DETAILS_ID asc
      ")
       ->pipe($this->dataStore("CPDEVALUATION"));

     $this->src("mysql")
       ->query("Select  *
        from cpd_management.PROGRAM_FEEDBACK AS PROGRAM_FEEDBACK")
      ->pipe($this->dataStore("CPDEVALUATIONFEEDBACK"));
      //$join = new Join($evaluation_source,$feed_back,array("PROG_DETAILS_ID"=>"PROG_DETAILS_ID"));
        //$join->pipe($this->dataStore('together'));
    }
}
