<?php
namespace App\Reports;
//use  \koolreport\KoolReport;

class CasEnquiryReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\inputs\POSTBinding;
    use \koolreport\inputs\Bindable;
    function defaultParamValues()
    {
        $start_date = date('Y-m-d', strtotime('-2 years')); //date('Y-m-d', strtotime('first day of january this year'));
        $end_date =date('Y-m-d'); //date('Y-m-d', strtotime('last day of december this year'));
        return array(
          //  "DISTRIBUTORID"=>2,
            // "DISTRIBUTORIDS" => array(0),
             "STATUSIDS" => array(0),
             "TYPEIDS" => array(0),
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
        );
    }
    function bindParamsToInputs()
    {
        return array(
           // "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
            "STATUSIDS" => "STATUSIDS",
            "TYPEIDS" => "TYPEIDS",
            "dateRange",
        );
    }
    function setup()
    {
        $query_params = array();
        if(isset($this->params["dateRange"][0]))
        {
        $query_params[":start"] = $this->params["dateRange"][0];
        }
        if(isset($this->params["dateRange"][1]))
        {
        $query_params[":end"] = $this->params["dateRange"][1];
        }
        if($this->params["STATUSIDS"] != array(0) )
        {
            $query_params[":STATUS_ID"] = $this->params["STATUSIDS"];
        }
        if($this->params["TYPEIDS"] != array(0) )
        {
            $query_params[":TYPE_ID"] = $this->params["TYPEIDS"];
        }
        $this->src("mysql")
        ->query("Select count(*) as total,CA_RECORD_DETAILS.CA_RECORD_DETAILS_ID AS CA_RECORD_DETAILS_ID, CA_RECORD_DETAILS.CA_RECORD_ID AS CA_RECORD_ID, CONSULTANT.CONSULTANT_ID AS CONSULTANT_ID,CONSULTANT.CONSULTANT_NAME AS CONSULTANT_NAME,CONSULTANT.CONSULTANT_NRIC AS CONSULTANT_NRIC,CONSULTANT.CONSULTANT_PASSPORT_NO AS CONSULTANT_PASSPORT_NO,SETTING_GENERAL.SET_PARAM AS SET_PARAM,CONSULTANT_TYPE.TYPE_NAME AS TYPE_NAME,CA_RECORD_DETAILS.CA_REASON AS CA_REASON,CA_RECORD_DETAILS.CA_REMARK AS CA_REMARK,CA_RECORD_DETAILS.CA_DATE_START AS CA_DATE_START,CA_RECORD_DETAILS.CA_DATE_END AS CA_DATE_END,CA_DOCUMENT.DOC_FILETYPE AS DOC_FILETYPE,CA_DOCUMENT.CA_DOCUMENT_ID AS CA_DOCUMENT_ID
        from consultant_management.CONSULTANT AS CONSULTANT
        JOIN consultantAlert_management.CA_RECORD AS CA_RECORD
            ON CA_RECORD.CONSULTANT_ID = CONSULTANT.CONSULTANT_ID
        LEFT JOIN consultantAlert_management.CA_RECORD_DETAILS AS CA_RECORD_DETAILS
            ON CA_RECORD_DETAILS.CA_RECORD_ID = CA_RECORD.CA_RECORD_ID
        left join consultantAlert_management.CA_DOCUMENT AS CA_DOCUMENT
            ON CA_DOCUMENT.CA_RECORD_DETAILS_ID = CA_RECORD_DETAILS.CA_RECORD_DETAILS_ID
        left join admin_management.SETTING_GENERAL AS SETTING_GENERAL
            ON SETTING_GENERAL.SETTING_GENERAL_ID = CONSULTANT.CONSULTANT_STATUS
        left join consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
            ON CONSULTANT_LICENSE.CONSULTANT_ID = CONSULTANT.CONSULTANT_ID
        left join admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE
            ON CONSULTANT_TYPE.CONSULTANT_TYPE_ID = CONSULTANT_LICENSE.CONSULTANT_TYPE_ID
        where SETTING_GENERAL.SET_TYPE = 'CLASSIFICATION'
        ".(( $this->params["dateRange"][0]?"and CA_RECORD_DETAILS.CA_DATE_START >= :start":""))."
        ".(( $this->params["dateRange"][1]?"and CA_RECORD_DETAILS.CA_DATE_END <= :end":""))." 
        ".(($this->params["STATUSIDS"]!=array(0))?"and CONSULTANT.CONSULTANT_STATUS in ( :STATUS_ID)":"")."
        ".(($this->params["TYPEIDS"]!=array(0))?"and CONSULTANT_LICENSE.CONSULTANT_TYPE_ID in ( :TYPE_ID)":"")."
        group by CA_RECORD_ID
        ORDER BY CA_RECORD_DETAILS_ID DESC
        ")
        ->params($query_params)
       ->pipe($this->dataStore("CASENQUIRY"));

       $this->src("mysql")
       ->query("Select SETTING_GENERAL.SETTING_GENERAL_ID AS STATUSID,SETTING_GENERAL.SET_PARAM AS SET_PARAM
        from admin_management.SETTING_GENERAL AS SETTING_GENERAL
        where SETTING_GENERAL.SET_TYPE = 'CLASSIFICATION'
        order by SETTING_GENERAL_ID asc")
       ->pipe($this->dataStore("CASSTATUS"));

       $this->src("mysql")
        ->query("Select CONSULTANT_TYPE.TYPE_NAME AS TYPE_NAME,CONSULTANT_TYPE.CONSULTANT_TYPE_ID AS TYPEID
         from admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE")
       ->pipe($this->dataStore("CASCONSULTANTTYPE"));
    }
}
