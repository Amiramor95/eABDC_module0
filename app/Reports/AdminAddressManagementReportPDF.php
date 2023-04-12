<?php
namespace App\Reports;
class AdminAddressManagementReportPDF extends \koolreport\KoolReport
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
       // $start_date = date('Y-m-d', strtotime('first day of this month'));
       // $end_date = date('Y-m-d', strtotime('last day of this month'));
        return array(
            // "dateRange"=>array(
            //     $start_date,
            //     $end_date
            // ),
            "COUNTRYID"=>0,
            "STATEID"=>0,
            "POSTCODEID"=>0,
        );
    }
    function bindParamsToInputs()
    {
        return array(
           // "dateRange"=>"dateRange",
           "COUNTRYID",
           "STATEID",
           "POSTCODEID",
        );
    }


    function setup()
    {
        //var_dump($this->params); echo "<br>";
        $this->src("mysql")
        ->query("Select COUNTRY.SET_PARAM AS COUNTRYNAME,COUNTRY.SETTING_GENERAL_ID AS COUNTRYID
         from admin_management.SETTING_GENERAL AS COUNTRY where COUNTRY.SET_TYPE = 'COUNTRY'")
        ->pipe($this->dataStore("COUNTRYLIST"));

        $this->src("mysql")
        ->query("Select STATE.SET_PARAM AS STATENAME,STATE.SETTING_GENERAL_ID AS STATEID
         from admin_management.SETTING_GENERAL AS STATE  WHERE STATE.SET_TYPE = 'STATE'
         AND STATE.SET_VALUE = :COUNTRY_ID
         order by STATENAME asc")
         ->params(array(
            ":COUNTRY_ID"=>$this->params["COUNTRYID"]
        ))
        ->pipe($this->dataStore("STATELIST"));

        $this->src("mysql")
        ->query("Select SETTING_POSTAL.POSTCODE_NO AS POSTCODENAME,SETTING_POSTAL.SETTING_POSTCODE_ID AS POSTCODEID
        from admin_management.SETTING_POSTAL AS SETTING_POSTAL
        LEFT JOIN admin_management.SETTING_CITY AS CITY
           ON CITY.SETTING_CITY_ID = SETTING_POSTAL.SETTING_CITY_ID
           where CITY.SETTING_GENERAL_ID = :STATE_ID")
         ->params(array(
            ":STATE_ID"=>$this->params["STATEID"]
        ))
        ->pipe($this->dataStore("POSTLIST"));


        $query_params = array();
        if($this->params["COUNTRYID"] != 0)
        {
            $query_params[":COUNTRY_ID"] = $this->params["COUNTRYID"];
        }
        if($this->params["STATEID"] != 0)
        {
            $query_params[":STATE_ID"] = $this->params["STATEID"];
        }
        if($this->params["POSTCODEID"] != 0)
        {
            $query_params[":POST_ID"] = $this->params["POSTCODEID"];
        }

       $this->src("mysql")
       ->query("Select SETTING_POSTAL.POSTCODE_NO AS POSTCODE,SETTING_POSTAL.POSTCODE_CREATE_TIMESTAMP AS POSTCODE_DATE,CITY.SET_CITY_NAME AS CITYNAME,STATE.SET_PARAM AS STATENAME,COUNTRY.SET_PARAM AS COUNTRYNAME
        from admin_management.SETTING_POSTAL AS SETTING_POSTAL
        LEFT JOIN admin_management.SETTING_CITY AS CITY
           ON CITY.SETTING_CITY_ID = SETTING_POSTAL.SETTING_CITY_ID
        LEFT JOIN admin_management.SETTING_GENERAL AS STATE
           ON STATE.SETTING_GENERAL_ID = CITY.SETTING_GENERAL_ID
        LEFT JOIN admin_management.SETTING_GENERAL AS COUNTRY
           ON COUNTRY.SETTING_GENERAL_ID = STATE.SET_VALUE
           WHERE STATE.SET_TYPE = 'STATE'
           ".(($this->params["COUNTRYID"]!= 0)?"and COUNTRY.SETTING_GENERAL_ID = :COUNTRY_ID":"")."
           ".(($this->params["STATEID"]!= 0)?"and STATE.SETTING_GENERAL_ID = :STATE_ID":"")."
           ".(($this->params["POSTCODEID"]!= 0)?"and SETTING_POSTAL.SETTING_POSTCODE_ID = :POST_ID":"")."
       ")
       ->params($query_params)
      ->pipe($this->dataStore("ADDRESSREPORT"));
    }
}
