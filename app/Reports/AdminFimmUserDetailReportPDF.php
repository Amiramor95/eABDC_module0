<?php
namespace App\Reports;
class AdminFimmUserDetailReportPDF extends \koolreport\KoolReport
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
        ->query("Select USER.USER_ID AS USER_ID,USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL,USER.USER_STATUS AS USER_STATUS,USER.KEYCLOAK_ID AS KEYCLOAK_ID,USER_ADDRESS.USER_PHONE AS PHONE,USER_ADDRESS.USER_COUNTRY AS COUNTRY,USER_ADDRESS.USER_CITY AS CITY,USER_ADDRESS.USER_STATE AS STATE,USER_ADDRESS.USER_POSTAL AS POSTAL,CONCAT_WS(', ',USER_ADDRESS.USER_ADDR_1, USER_ADDRESS.USER_ADDR_2,USER_ADDRESS.USER_ADDR_3) AS ADDRESS,MANAGE_DEPARTMENT.DPMT_NAME AS DPMT_NAME,MANAGE_DIVISION.DIV_NAME AS DIV_NAME,MANAGE_GROUP.GROUP_NAME AS GROUP_NAME,EVENT_ENTITY.IP_ADDRESS AS IP,AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_NAME AS USERROLE,EVENT_ENTITY.USER_ID AS UID, count(*) as t,USER.USER_NRIC AS NRIC
        from admin_management.USER AS USER
        LEFT JOIN admin_management.MANAGE_GROUP AS MANAGE_GROUP
        ON MANAGE_GROUP.MANAGE_GROUP_ID = USER.USER_GROUP
        LEFT JOIN admin_management.USER_ADDRESS AS USER_ADDRESS
        ON USER_ADDRESS.USER_ID = USER.USER_ID
        LEFT JOIN admin_management.MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT
        ON MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID = MANAGE_GROUP.MANAGE_DEPARTMENT_ID
        LEFT JOIN admin_management.MANAGE_DIVISION AS MANAGE_DIVISION
        ON MANAGE_DIVISION.MANAGE_DIVISION_ID = MANAGE_DEPARTMENT.MANAGE_DIVISION_ID
        LEFT JOIN keycloak2.EVENT_ENTITY AS EVENT_ENTITY
        ON EVENT_ENTITY.USER_ID = USER.KEYCLOAK_ID 
        LEFT JOIN admin_management.AUTHORIZATION_LEVEL AS AUTHORIZATION_LEVEL
        ON AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_ID = USER.USER_ROLE
        where USER.USER_ID = :USER_ID
        GROUP BY UID
        ")
        ->params(array(
            ":USER_ID"=>$this->params["UID"]
        ))
        ->pipe($this->dataStore("FIMMUSERDETAIL"));

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
