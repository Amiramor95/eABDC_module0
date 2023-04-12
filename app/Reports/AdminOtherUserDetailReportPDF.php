<?php
namespace App\Reports;
class AdminOtherUserDetailReportPDF extends \koolreport\KoolReport
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
        ->query("Select USER.TP_USERID AS USER_ID,USER.TP_USER_FNAME AS USER_NAME,USER.TP_USER_EMAIL AS USER_EMAIL,USER.TP_STATUS AS USER_STATUS,USER.KEYCLOAK_ID AS KEYCLOAK_ID,USER.TP_USER_TELEPHONE AS PHONE,USER.TP_USER_COUNTRY AS COUNTRY,USER.TP_USER_CITY AS CITY,USER.TP_USER_STATE AS STATE,USER.TP_USER_POSTAL AS POSTAL,CONCAT_WS(', ',USER.TP_USER_ADDR1, USER.TP_USER_ADDR2,USER.TP_USER_ADDR3) AS ADDRESS,MANAGE_DEPARTMENT.DPMT_NAME AS DPMT_NAME,MANAGE_DIVISION.DIV_NAME AS DIV_NAME,MANAGE_GROUP.GROUP_NAME AS GROUP_NAME,EVENT_ENTITY.IP_ADDRESS AS IP, EVENT_ENTITY.USER_ID AS UID, count(*) as t,USER.TP_USER_NRIC AS NRIC,TP_USER_COMPANY.TP_NAME AS COMPANY,USER.TP_USER_TYPE AS UTYPE
        from funds_management.TP_USER AS USER
        LEFT JOIN admin_management.MANAGE_GROUP AS MANAGE_GROUP
        ON MANAGE_GROUP.MANAGE_GROUP_ID = USER.TP_USER_GROUP
        LEFT JOIN admin_management.MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT
        ON MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID = MANAGE_GROUP.MANAGE_DEPARTMENT_ID
        LEFT JOIN admin_management.MANAGE_DIVISION AS MANAGE_DIVISION
        ON MANAGE_DIVISION.MANAGE_DIVISION_ID = MANAGE_DEPARTMENT.MANAGE_DIVISION_ID
        LEFT JOIN keycloak2.EVENT_ENTITY AS EVENT_ENTITY
        ON EVENT_ENTITY.USER_ID = USER.KEYCLOAK_ID 
        LEFT JOIN funds_management.TP_USER_COMPANY AS TP_USER_COMPANY
        ON TP_USER_COMPANY.TP_USER_COMP_ID = USER.TP_COMP_ID 
        where USER.TP_USER_ID = :USER_ID
        GROUP BY UID
        ")
        ->params(array(
            ":USER_ID"=>$this->params["UID"]
        ))
        ->pipe($this->dataStore("OTHERUSERDETAIL"));

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
