<?php
namespace App\Reports;
class AdminCalendarManagementReportPDF extends \koolreport\KoolReport
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
        $start_date = date('Y-m-d', strtotime('first day of January'));
        $end_date = date('Y-m-d', strtotime('last day of December'));
        return array(
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
            "CALENDARID"=>0,
        );
    }
    function bindParamsToInputs()
    {
        return array(
            "dateRange"=>"dateRange",
           "CALENDARID",
        );
    }


    function setup()
    {
        //var_dump($this->params); echo "<br>";
        $this->src("mysql")
        ->query("Select SETTING_CALENDAR.CALENDAR_NAME AS EVENTNAME,SETTING_CALENDAR.SETTING_CALENDAR_ID AS CALENDARID
         from admin_management.SETTING_CALENDAR AS SETTING_CALENDAR")
        ->pipe($this->dataStore("EVENTLIST"));

        $query_params = array();
        if($this->params["CALENDARID"] != 0)
        {
            $query_params[":CALENDAR_ID"] = $this->params["CALENDARID"];
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
       ->query("Select SETTING_CALENDAR.CALENDAR_NAME AS EVENTNAME,SETTING_CALENDAR.CALENDAR_DATE_START AS STARTDATE,SETTING_CALENDAR.CALENDAR_DATE_END AS ENDDATE,YEAR(SETTING_CALENDAR.CALENDAR_DATE_START) AS YEAR,MONTH(SETTING_CALENDAR.CALENDAR_DATE_START) AS MONTH
        from admin_management.SETTING_CALENDAR AS SETTING_CALENDAR
           WHERE 1 = 1
           ".(($this->params["CALENDARID"]!= 0)?"and SETTING_CALENDAR.SETTING_CALENDAR_ID = :CALENDAR_ID":"")."
           ".(( $this->params["dateRange"][0]?"and SETTING_CALENDAR.CALENDAR_DATE_START >= :start":""))."
           ".(( $this->params["dateRange"][1]?"and SETTING_CALENDAR.CALENDAR_DATE_END <= :end":""))."
       ")
       ->params($query_params)
      ->pipe($this->dataStore("CALENDARREPORT"));
    }
}
