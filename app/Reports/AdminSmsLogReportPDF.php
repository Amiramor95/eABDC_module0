<?php
namespace App\Reports;
class AdminSmsLogReportPDF extends \koolreport\KoolReport
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
        $start_date = date('Y-m-d', strtotime('first day of january last year'));
        $end_date = date('Y-m-d', strtotime('last day of december this year'));
        return array(
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
        );
    }
    function bindParamsToInputs()
    {
        return array(
            "dateRange"=>"dateRange",
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
       $this->src("mysql")
       ->query("Select *
        from admin_management.SMS_LOG AS SMS_LOG
        WHERE 1 = 1
        ".(( $this->params["dateRange"][0]?"and DATE_SEND >= :start":""))."
        ".(( $this->params["dateRange"][1]?"and DATE_SEND <= :end":""))." 
       ")
       ->params($query_params)
      ->pipe($this->dataStore("SMSLOGREPORT"));
    }
}
