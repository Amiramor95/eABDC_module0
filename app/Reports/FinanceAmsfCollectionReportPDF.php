<?php
namespace App\Reports;
use \koolreport\querybuilder\DB;
class FinanceAmsfCollectionReportPDF extends \koolreport\KoolReport
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
            "DISTRIBUTORID"=>0,
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
       ->query("Select 
                TRANSACTION_LEDGER_FIMM.TRANSACTION_LEDGER_ID AS LEDGER_ID,
                TRANSACTION_LEDGER_FIMM.DISTRIBUTOR_ID AS DIST_ID,
                C.DIST_NAME AS DIST_NAME,
                TRANSACTION_LEDGER_FIMM.TRANS_REMARK AS TRANS_REMARK,
                TRANSACTION_LEDGER_FIMM.RETURN_ACKNOWLEDGED_REMARKS AS RETURN_ACKNOWLEDGED_REMARKS,
                TRANSACTION_LEDGER_FIMM.PAYMENT_REFERENCE AS PAYMENT_REFERENCE,
                F.FIN_CODE AS CODE,
                D.TS_PARAM AS STATUS,
                H.SET_PARAM AS FINTYPE,
                TRANSACTION_LEDGER_FIMM.CREATE_TIMESTAMP AS DATE,
                TRANSACTION_LEDGER_FIMM.TRANS_STATUS AS TRANS_STATUS,
                TRANSACTION_LEDGER_FIMM.RETURN_ACKNOWLEDGED_REMARKS,
                TRANSACTION_LEDGER_FIMM.OTHERS_REMARKS AS OTHERS_REMARKS,
                TRANSACTION_LEDGER_FIMM.DIST_TRANS_TYPE AS DIST_TRANS_TYPE,
                TRANSACTION_LEDGER_FIMM.DEBIT_AMOUNT AS DEBIT_AMOUNT ,
                TRANSACTION_LEDGER_FIMM.CREDIT_AMOUNT AS CREDIT_AMOUNT,
                TRANSACTION_LEDGER_FIMM.OTHERS_AMOUNT AS OTHERS_AMOUNT
        from finance_management.TRANSACTION_LEDGER_FIMM AS TRANSACTION_LEDGER_FIMM
         JOIN distributor_management.DISTRIBUTOR AS C ON C.DISTRIBUTOR_ID = TRANSACTION_LEDGER_FIMM.DISTRIBUTOR_ID
        LEFT JOIN admin_management.TASK_STATUS AS D ON  D.TS_ID = TRANSACTION_LEDGER_FIMM.TRANS_STATUS
        LEFT JOIN admin_management.FINANCE_CODE AS F ON F.DIST_ID = TRANSACTION_LEDGER_FIMM.DISTRIBUTOR_ID
        LEFT JOIN admin_management.SETTING_GENERAL AS H ON H.SET_VALUE = TRANSACTION_LEDGER_FIMM.FIN_TRANS_TYPE
        where F.STATUS = 1 AND H.SET_TYPE = 'FINANCETYPE' AND TRANSACTION_LEDGER_FIMM.FIN_TRANS_TYPE = 5
        ".(($this->params["DISTRIBUTORID"]!= 0)?"and TRANSACTION_LEDGER_FIMM.DISTRIBUTOR_ID = :DISTRIBUTOR_ID":"")."
        ".(( $this->params["dateRange"][0]?"and TRANSACTION_LEDGER_FIMM.CREATE_TIMESTAMP >= :start":""))."
        ".(( $this->params["dateRange"][1]?"and TRANSACTION_LEDGER_FIMM.CREATE_TIMESTAMP <= :end":""))." 
        ")
       ->params($query_params)
      ->pipe($this->dataStore("FINANCEAMSFCOLLECTIONREPORT"));

      $this->src("mysql")
      ->query("select DISTRIBUTOR_TYPE.DIST_ID AS DIST_ID,DISTRIBUTORTYPE.DIST_TYPE_NAME AS DIST_TYPE_NAME,DISTRIBUTORTYPE.DISTRIBUTOR_TYPE_ID AS DISTRIBUTOR_TYPE_ID
      from distributor_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE
      LEFT JOIN admin_management.DISTRIBUTOR_TYPE AS DISTRIBUTORTYPE
      ON DISTRIBUTORTYPE.DISTRIBUTOR_TYPE_ID = DISTRIBUTOR_TYPE.DIST_TYPE
      ")
      ->pipe($this->dataStore("DISTRIBUTORTYPE"));

      $this->src("mysql")
      ->query("select AMSF_TRANSACTION_MAIN.DISTRIBUTOR_ID AS DISTRIBUTOR_ID,AMSF_TRANSACTION_MAIN.AMSF_AMOUNT AS AMSF_AMOUNT
      from finance_management.AMSF_TRANSACTION_MAIN AS AMSF_TRANSACTION_MAIN
      ")
      ->pipe($this->dataStore("DISTRIBUTORBALANCEAMOUNT"));

    }
}
