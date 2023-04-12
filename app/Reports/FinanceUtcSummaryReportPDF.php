<?php
namespace App\Reports;
class FinanceUtcSummaryReportPDF extends \koolreport\KoolReport
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
        $start_date = date('Y-m-d', strtotime('first day of january this year'));
        $end_date = date('Y-m-d', strtotime('last day of december this year'));
        return array(
            "DISTRIBUTORID"=>2,
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
        );
    }
    function bindParamsToInputs()
    {
        return array(
            "DISTRIBUTORID",
            "dateRange",
        );
    }


    function setup()
    {
        $query_params = array();
        if($this->params["DISTRIBUTORID"] != 0)
        {
            $query_params[":DISTRIBUTOR_ID"] = $this->params["DISTRIBUTORID"];
        }
        if(isset($this->params["dateRange"][0]))
        {
        $query_params[":start"] = $this->params["dateRange"][0];
        }
        if(isset($this->params["dateRange"][1]))
        {
        $query_params[":end"] = $this->params["dateRange"][1];
        }
        $this->src("mysql")
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID
         from distributor_management.DISTRIBUTOR AS DISTRIBUTOR order by DISTRIBUTOR_ID asc")
       ->pipe($this->dataStore("FINANCECOMPANY"));

       $this->src("mysql")
       ->query("Select CONSULTANT.CONSULTANT_NAME AS NAME,CONSULTANT.CONSULTANT_NRIC AS NRIC,SETTING_GENERAL.SET_PARAM AS STATUS,CONSULTANT_TYPE.TYPE_NAME AS TYPE_NAME,CONSULTANT_LICENSE_FEE.TOTAL_AMOUNT_FEE AS AMOUNT,TASK_STATUS.TS_PARAM AS TS_PARAM,CONSULTANT_LICENSE_FEE.CREATED_AT AS CREATED_AT
        from consultant_management.CONSULTANT AS CONSULTANT
        left join consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE ON CONSULTANT_LICENSE.CONSULTANT_ID = CONSULTANT.CONSULTANT_ID
        left join admin_management.SETTING_GENERAL AS SETTING_GENERAL ON SETTING_GENERAL.SETTING_GENERAL_ID = CONSULTANT_LICENSE.CONSULTANT_STATUS
        left join admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE ON CONSULTANT_TYPE.CONSULTANT_TYPE_ID = CONSULTANT_LICENSE.CONSULTANT_TYPE_ID
        left join consultant_management.CONSULTANT_LICENSE_FEE AS CONSULTANT_LICENSE_FEE ON CONSULTANT_LICENSE_FEE.CONSULTANT_LICENSE_ID = CONSULTANT_LICENSE.CONSULTANT_LICENSE_ID
        left join admin_management.TASK_STATUS AS TASK_STATUS ON TASK_STATUS.TS_ID = CONSULTANT_LICENSE_FEE.TS_ID
       where CONSULTANT_LICENSE.CONSULTANT_TYPE_ID = 2
       ".(($this->params["DISTRIBUTORID"]!= 0)?"and CONSULTANT_LICENSE.DISTRIBUTOR_ID = :DISTRIBUTOR_ID":"")."
       ".(( $this->params["dateRange"][0]?"and CONSULTANT_LICENSE.CREATED_AT >= :start":""))."
       ".(( $this->params["dateRange"][1]?"and CONSULTANT_LICENSE.CREATED_AT <= :end":""))." 
       ")
       ->params($query_params)
      ->pipe($this->dataStore("FINANCEPRCREPORT"));
    }
}
