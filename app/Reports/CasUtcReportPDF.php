<?php
namespace App\Reports;
class CasUtcReportPDF extends \koolreport\KoolReport
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
             "DISTRIBUTORIDS" => array(0),
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
            "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
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
        if($this->params["DISTRIBUTORIDS"] != array(0) )
        {
            $query_params[":DISTRIBUTOR_ID"] = $this->params["DISTRIBUTORIDS"];
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
        ->query("Select CONSULTANT.CONSULTANT_ID AS CONSULTANT_ID,CONSULTANT.CONSULTANT_NAME AS CONSULTANT_NAME,CONSULTANT.CONSULTANT_NRIC AS CONSULTANT_NRIC,CONSULTANT.CONSULTANT_PASSPORT_NO AS CONSULTANT_PASSPORT_NO,CONSULTANT.CONSULTANT_FIMM_NO AS CONSULTANT_FIMM_NO,CONSULTANT.CONSULTANT_FIMM_NO AS CONSULTANT_FIMM_NO,CONSULTANT.CREATE_TIMESTAMP AS START_DATE,SETTING_GENERAL.SET_PARAM AS SET_PARAM,CA_RECORD.CREATE_TIMESTAMP AS UPDATE_DATE,DISTRIBUTOR.DIST_NAME AS DIST_NAME,CONSULTANT_TYPE.TYPE_NAME AS TYPE_NAME 
        from consultant_management.CONSULTANT AS CONSULTANT 
        JOIN consultantAlert_management.CA_RECORD AS CA_RECORD ON CA_RECORD.CONSULTANT_ID = CONSULTANT.CONSULTANT_ID 
        left join admin_management.SETTING_GENERAL AS SETTING_GENERAL ON SETTING_GENERAL.SETTING_GENERAL_ID = CONSULTANT.CONSULTANT_STATUS 
        left join distributor_management.DISTRIBUTOR AS DISTRIBUTOR ON DISTRIBUTOR.DISTRIBUTOR_ID = CONSULTANT.DISTRIBUTOR_ID 
        left join consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE ON CONSULTANT_LICENSE.CONSULTANT_ID = CONSULTANT.CONSULTANT_ID 
        left join admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE ON CONSULTANT_TYPE.CONSULTANT_TYPE_ID = CONSULTANT_LICENSE.CONSULTANT_TYPE_ID 
        where SETTING_GENERAL.SET_TYPE = 'CLASSIFICATION'
        ".(( $this->params["dateRange"][0]?"and CONSULTANT.CREATE_TIMESTAMP >= :start":""))."
        ".(( $this->params["dateRange"][1]?"and CA_RECORD.CREATE_TIMESTAMP <= :end":""))." 
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and DISTRIBUTOR.DISTRIBUTOR_ID in ( :DISTRIBUTOR_ID)":"")."
        ".(($this->params["STATUSIDS"]!=array(0))?"and CONSULTANT.CONSULTANT_STATUS in ( :STATUS_ID)":"")."
        ".(($this->params["TYPEIDS"]!=array(0))?"and CONSULTANT_LICENSE.CONSULTANT_TYPE_ID in ( :TYPE_ID)":"")."
        ")
        ->params($query_params)
       ->pipe($this->dataStore("CONSULTANTS"));

       $this->src("mysql")
       ->query("Select SETTING_GENERAL.SETTING_GENERAL_ID AS STATUSID,SETTING_GENERAL.SET_PARAM AS SET_PARAM
        from admin_management.SETTING_GENERAL AS SETTING_GENERAL
        where SETTING_GENERAL.SET_TYPE = 'CLASSIFICATION'
        order by SETTING_GENERAL_ID asc")
       ->pipe($this->dataStore("CASSTATUS"));
       $this->src("mysql")
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID
         from distributor_management.DISTRIBUTOR AS DISTRIBUTOR order by DISTRIBUTOR_ID asc")
       ->pipe($this->dataStore("CASCOMPANY"));

       $this->src("mysql")
        ->query("Select CONSULTANT_TYPE.TYPE_NAME AS TYPE_NAME,CONSULTANT_TYPE.CONSULTANT_TYPE_ID AS TYPEID
         from admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE")
       ->pipe($this->dataStore("CASCONSULTANTTYPE"));
    }
}
