<?php
namespace App\Reports;
class AdminConsultantUserDetailReportPDF extends \koolreport\KoolReport
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
        ->query("Select USER.USER_ID AS USER_ID,USER.USER_NRIC AS USER_NRIC,USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL,USER.USER_MOBILE_NUM AS PHONE,USER.USER_STATUS AS USER_STATUS,USER.KEYCLOAK_ID AS KEYCLOAK_ID,MANAGE_DEPARTMENT.DPMT_NAME AS DPMT_NAME,MANAGE_DIVISION.DIV_NAME AS DIV_NAME,MANAGE_GROUP.GROUP_NAME AS GROUP_NAME,DISTRIBUTOR.DIST_NAME AS COMPANY
        from consultant_management.USER AS USER
        LEFT JOIN admin_management.MANAGE_GROUP AS MANAGE_GROUP
        ON MANAGE_GROUP.MANAGE_GROUP_ID = USER.USER_GROUP 
        LEFT JOIN admin_management.MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT
        ON MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID = MANAGE_GROUP.MANAGE_DEPARTMENT_ID
        LEFT JOIN admin_management.MANAGE_DIVISION AS MANAGE_DIVISION
        ON MANAGE_DIVISION.MANAGE_DIVISION_ID = MANAGE_DEPARTMENT.MANAGE_DIVISION_ID
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = USER.USER_DIST_ID
        where USER.USER_ID = :USER_ID
        ")
        ->params(array(
            ":USER_ID"=>$this->params["UID"]
        ))
        ->pipe($this->dataStore("CONSULTANTUSERDETAIL"));

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
