<?php
namespace App\Reports;
class CpdProgramRepeatedReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    function setup()
    {
        $this->src("mysql")
        ->query("Select DISTRIBUTOR.DIST_NAME AS COMPANY,TP_USER_COMPANY.TP_NAME AS COMPANY1,PROGRAM.PROG_CODE AS PROG_CODE,PROGRAM.PROG_TITLE AS PROG_TITLE,PROGRAM_DETAILS.PROG_DATE_START AS PROG_DATE_START,PROGRAM_DETAILS.POINT AS POINT,PROGRAM_SLO.SPEAKER AS SPEAKER,TASK_STATUS.TS_PARAM AS TS_PARAM,PROGRAM.CATEGORY AS CATEGORY
         from cpd_management.PROGRAM AS PROGRAM
         left join cpd_management.PROGRAM_DETAILS AS PROGRAM_DETAILS ON PROGRAM_DETAILS.PROGRAM_ID = PROGRAM.PROGRAM_ID left join cpd_management.PROGRAM_SLO AS PROGRAM_SLO ON PROGRAM_SLO.PROG_DETAILS_ID = PROGRAM_DETAILS. 	PROG_DETAILS_ID
         left join cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL ON PROGRAM_APPROVAL.PROG_DETAILS_ID = PROGRAM_DETAILS.PROG_DETAILS_ID
         left join admin_management.TASK_STATUS AS TASK_STATUS ON TASK_STATUS.TS_ID = PROGRAM_APPROVAL.TS_ID
         left join distributor_management.DISTRIBUTOR AS DISTRIBUTOR ON DISTRIBUTOR.DISTRIBUTOR_ID = PROGRAM.COMPANY_ID AND PROGRAM.CATEGORY = 2
         left join funds_management.TP_USER_COMPANY AS TP_USER_COMPANY ON TP_USER_COMPANY.TP_USER_COMP_ID = PROGRAM.COMPANY_ID AND PROGRAM.CATEGORY = 3
         where PROGRAM_APPROVAL.TS_ID IN(2,3,4,5,8,14,15,17,30) AND PROGRAM.CATEGORY IN(2,3)")
       ->pipe($this->dataStore("PROGRAMREPEATED"));
    }
}
