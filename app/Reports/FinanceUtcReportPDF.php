<?php
namespace App\Reports;
class FinanceUtcReportPDF extends \koolreport\KoolReport
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
       ->query("Select CONSULTANT.CONSULTANT_NAME AS NAME,CONSULTANT.CONSULTANT_NRIC AS NRIC,SETTING_GENERAL.SET_PARAM AS STATUS,CONSULTANT_TYPE.TYPE_NAME AS TYPE_NAME,CONSULTANT_LICENSE_FEE.TOTAL_AMOUNT_FEE AS AMOUNT,TASK_STATUS.TS_PARAM AS TS_PARAM,CONSULTANT_LICENSE_FEE.CREATED_AT AS CREATED_AT,FINANCETYPE.SET_PARAM AS TYPENAME,TRANSACTION_LEDGER.FIN_TRANS_TYPE AS FIN_TRANS_TYPE,CONSULTANT_FEE.TAX_FEE AS GST
        from finance_management.CONSULTANT_REGISTRATION_DETAILS AS CONSULTANT_REGISTRATION_DETAILS
         join consultant_management.CONSULTANT_LICENSE_FEE AS CONSULTANT_LICENSE_FEE ON CONSULTANT_LICENSE_FEE.CONSULTANT_LICENSE_FEE_ID = CONSULTANT_REGISTRATION_DETAILS.CONSULTANT_LICENSE_FEE_ID
         join consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE ON CONSULTANT_LICENSE.CONSULTANT_LICENSE_ID = CONSULTANT_LICENSE_FEE.CONSULTANT_LICENSE_ID
         join consultant_management.CONSULTANT AS CONSULTANT ON CONSULTANT.CONSULTANT_ID = CONSULTANT_LICENSE.CONSULTANT_ID
         join finance_management.TRANSACTION_LEDGER AS TRANSACTION_LEDGER ON TRANSACTION_LEDGER.LEDGER_ID = CONSULTANT_REGISTRATION_DETAILS.LEDGER_ID
         left join admin_management.SETTING_GENERAL AS SETTING_GENERAL ON SETTING_GENERAL.SETTING_GENERAL_ID = CONSULTANT_LICENSE.CONSULTANT_STATUS
        left join admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE ON CONSULTANT_TYPE.CONSULTANT_TYPE_ID = CONSULTANT_LICENSE.CONSULTANT_TYPE_ID
        left join admin_management.TASK_STATUS AS TASK_STATUS ON TASK_STATUS.TS_ID = CONSULTANT_LICENSE_FEE.TS_ID
        left join admin_management.SETTING_GENERAL AS FINANCETYPE ON FINANCETYPE.SET_VALUE = TRANSACTION_LEDGER.FIN_TRANS_TYPE
        left join admin_management.CONSULTANT_FEE AS CONSULTANT_FEE ON CONSULTANT_FEE.CONSULTANT_FEE_TYPE_ID = FINANCETYPE.SETTING_GENERAL_ID
       where CONSULTANT_LICENSE.CONSULTANT_TYPE_ID = 1 AND FINANCETYPE.SET_TYPE = 'FINANCETYPE'
       ".(($this->params["DISTRIBUTORID"]!= 0)?"and TRANSACTION_LEDGER.DISTRIBUTOR_ID = :DISTRIBUTOR_ID":"")."
       ".(( $this->params["dateRange"][0]?"and CONSULTANT_LICENSE_FEE.CREATED_AT >= :start":""))."
       ".(( $this->params["dateRange"][1]?"and CONSULTANT_LICENSE_FEE.CREATED_AT <= :end":""))." 
       GROUP BY CONSULTANT.CONSULTANT_ID
       ORDER BY CONSULTANT_LICENSE_FEE.CREATED_AT DESC
       ")
       ->params($query_params)
      ->pipe($this->dataStore("FINANCEUTCREPORT"));
    }
}
