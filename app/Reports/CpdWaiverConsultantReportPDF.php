<?php
namespace App\Reports;
class CpdWaiverConsultantReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;
    function defaultParamValues()
    {
        $cyear = date('Y');
        $cmonth = 01;
        return array(
            "CONSULTANTYEAR"=>$cyear,
            "CONSULTANTMONTH"=>$cmonth,
            "CID" =>$this->params["CID"],
           
        );
    }
    function bindParamsToInputs()
    {
        return array(
            "CONSULTANTYEAR",
            "CID",
            "CONSULTANTMONTH"
        );
    }
    function setup()
    {
       
        $this->src("mysql")
        ->query("Select CONSULTANT.CONSULTANT_NAME AS CONSULTANT_NAME,CONSULTANT.CONSULTANT_NRIC AS CONSULTANT_NRIC,CONSULTANT.CONSULTANT_FIMM_NO AS CONSULTANT_FIMM_NO,DISTRIBUTOR.DIST_NAME AS DIST_NAME,CONSULTANT.CONSULTANT_ID AS CONSULTANT_ID,YEAR(CONSULTANT.CREATE_TIMESTAMP) AS CONSULTANTYEAR,MONTH(CONSULTANT.CREATE_TIMESTAMP) AS MONTH
         from consultant_management.CONSULTANT AS CONSULTANT
         left join distributor_management.DISTRIBUTOR AS DISTRIBUTOR ON DISTRIBUTOR.DISTRIBUTOR_ID = CONSULTANT.DISTRIBUTOR_ID
        where CONSULTANT.CONSULTANT_ID = :CONSULTANT_ID")
         ->params(array(
            ":CONSULTANT_ID"=>$this->params["CID"]
        ))
       ->pipe($this->dataStore("WAIVERCONSULTANTREPORT"));
      
       $this->src("mysql")
       ->query("Select CPD_WAIVER_REASON.WAIVER_REASON AS REASON,WAIVER_PARTICIPANT.YEAR AS YEAR,TASK_STATUS.TS_PARAM AS APPROVAL_STATUS,CPD_RENEWAL_CALC.RENEWAL_REQUIREMENT AS RENEWAL_REQUIREMENT
        from cpd_management.WAIVER_PARTICIPANT AS WAIVER_PARTICIPANT
        left join admin_management.TASK_STATUS AS TASK_STATUS ON TASK_STATUS.TS_ID = WAIVER_PARTICIPANT.TS_ID
        left join admin_management.CPD_WAIVER_REASON AS CPD_WAIVER_REASON ON CPD_WAIVER_REASON.WAIVER_REASON_ID = WAIVER_PARTICIPANT.WAIVER_REASON_ID
        join admin_management.CPD_RENEWAL_CALC AS CPD_RENEWAL_CALC ON CPD_RENEWAL_CALC.EFFECTIVE_YEAR = WAIVER_PARTICIPANT.YEAR
       where WAIVER_PARTICIPANT.CONSULTANT_ID = :CONSULTANT_ID AND WAIVER_PARTICIPANT.YEAR = :CONSULTANTYEAR AND CPD_RENEWAL_CALC.RENEWAL_MONTH = :CONSULTANTMONTH
       ")
        ->params(array(
           ":CONSULTANT_ID"=>$this->params["CID"],
           ":CONSULTANTYEAR"=>$this->params["CONSULTANTYEAR"],
           ":CONSULTANTMONTH"=>$this->params["CONSULTANTMONTH"],
       ))
      ->pipe($this->dataStore("WAIVERCONSULTANTREPORTDETAIL"));

    }
}
