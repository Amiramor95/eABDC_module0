<?php
namespace App\Reports;
class AdminDistributorUserDetailReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;

    function setup()
    {
        $this->src("mysql")
        ->query("Select USER.USER_USER_ID AS USER_ID,USER.USER_NRIC AS USER_NRIC,USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL,USER.USER_STATUS AS USER_STATUS,USER.KEYCLOAK_ID AS KEYCLOAK_ID,USER.USER_MOBILE_NUM AS PHONE,COUNTRY.SET_PARAM AS COUNTRY,SETTING_CITY.SET_CITY_NAME AS CITY,STATENAME.SET_PARAM AS STATE,SETTING_POSTAL.POSTCODE_NO AS POSTAL,CONCAT_WS(', ',USER_ADDRESS.USER_ADDR_1, USER_ADDRESS.USER_ADDR_2,USER_ADDRESS.USER_ADDR_3) AS ADDRESS,MANAGE_DEPARTMENT.DPMT_NAME AS DPMT_NAME,MANAGE_DIVISION.DIV_NAME AS DIV_NAME,MANAGE_GROUP.GROUP_NAME AS GROUP_NAME,EVENT_ENTITY.IP_ADDRESS AS IP,EVENT_ENTITY.USER_ID AS UID, count(*) as t,DISTRIBUTOR.DIST_NAME AS COMPANY
        from distributor_management.USER AS USER
        LEFT JOIN admin_management.MANAGE_GROUP AS MANAGE_GROUP
        ON MANAGE_GROUP.MANAGE_GROUP_ID = USER.USER_GROUP
        LEFT JOIN distributor_management.USER_ADDRESS AS USER_ADDRESS
        ON USER_ADDRESS.USER_ID = USER.USER_ID
        LEFT JOIN admin_management.MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT
        ON MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID = MANAGE_GROUP.MANAGE_DEPARTMENT_ID
        LEFT JOIN admin_management.MANAGE_DIVISION AS MANAGE_DIVISION
        ON MANAGE_DIVISION.MANAGE_DIVISION_ID = MANAGE_DEPARTMENT.MANAGE_DIVISION_ID
        LEFT JOIN keycloak2.EVENT_ENTITY AS EVENT_ENTITY
        ON EVENT_ENTITY.USER_ID = USER.KEYCLOAK_ID 
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = USER.USER_DIST_ID 
        LEFT JOIN admin_management.SETTING_GENERAL AS COUNTRY
        ON COUNTRY.SETTING_GENERAL_ID = USER_ADDRESS.USER_ADDR_COUNTRY 
        LEFT JOIN admin_management.SETTING_CITY AS SETTING_CITY
        ON SETTING_CITY.SETTING_CITY_ID = USER_ADDRESS.USER_ADDR_CITY
        LEFT JOIN admin_management.SETTING_GENERAL AS STATENAME
        ON STATENAME.SETTING_GENERAL_ID = USER_ADDRESS.USER_ADDR_STATE 
        LEFT JOIN admin_management.SETTING_POSTAL AS SETTING_POSTAL
        ON SETTING_POSTAL.SETTING_POSTCODE_ID = USER_ADDRESS.USER_ADDR_STATE 
        where USER.USER_ID = :USER_ID
        GROUP BY UID
        ")
        ->params(array(
            ":USER_ID"=>$this->params["UID"]
        ))
        ->pipe($this->dataStore("DISTRIBUTORUSERDETAIL"));

        // $this->src("mysql")
        // ->query("Select * 
        //  from admin_management.
        // ")
        // ->params(array(
        //     ":USER_ID"=>$this->params["UID"]
        // ))
        // ->pipe($this->dataStore("FIMMUSERLEVEL"));
  }
}
