<?php
namespace App\Reports;
class AdminUserSummaryReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;
    //use \koolreport\cloudexport\Exportable;

    function setup()
    {
        $this->src("mysql")
        ->query("Select USER.USER_ID AS USER_ID,USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL,USER.USER_STATUS AS USER_STATUS,USER_ADDRESS.USER_STATE AS STATE,USER.KEYCLOAK_ID AS KID
        from admin_management.USER AS USER
        LEFT JOIN admin_management.USER_ADDRESS AS USER_ADDRESS
        ON USER_ADDRESS.USER_ID = USER.USER_ID
       
        order by USER_ID asc")
        ->pipe($this->dataStore("FIMMUSERSUMMARY"));

        $this->src("mysql")
        ->query("Select USER.USER_ID AS USER_ID,USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL,DISTRIBUTOR.DIST_NAME AS COMPANY,USER.USER_STATUS AS USER_STATUS,USER_ADDRESS.USER_ADDR_STATE AS STATE,USER.KEYCLOAK_ID AS KID
        from distributor_management.USER AS USER
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = USER.USER_DIST_ID 
        LEFT JOIN distributor_management.USER_ADDRESS AS USER_ADDRESS
        ON USER_ADDRESS.USER_ID = USER.USER_ID
        order by USER_ID asc")
        ->pipe($this->dataStore("DISTRIBUTORUSERSUMMARY"));

        $this->src("mysql")
        ->query("Select USER.USER_ID AS USER_ID,USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL,DISTRIBUTOR.DIST_NAME AS COMPANY,USER.USER_STATUS AS USER_STATUS,USER.KEYCLOAK_ID AS KID
        from consultant_management.USER AS USER
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = USER.USER_DIST_ID 
        order by USER_ID asc")
        ->pipe($this->dataStore("CONSULTANTUSERSUMMARY"));

        $this->src("mysql")
        ->query("Select USER.TP_USER_ID AS USER_ID,USER.TP_USER_FNAME AS USER_NAME,USER.TP_USER_EMAIL AS USER_EMAIL,TP_USER_COMPANY.TP_NAME AS COMPANY,USER.TP_STATUS AS USER_STATUS,USER.TP_USER_STATE AS STATE,USER.KEYCLOAK_ID AS KID
        from funds_management.TP_USER AS USER
        LEFT JOIN funds_management.TP_USER_COMPANY AS TP_USER_COMPANY
        ON TP_USER_COMPANY.TP_USER_COMP_ID = USER.TP_COMP_ID
        order by USER.TP_USER_ID asc")
        ->pipe($this->dataStore("OTHERSUSERSUMMARY"));

        $this->src("mysql")
        ->query("Select EVENT_ENTITY.IP_ADDRESS AS IP,EVENT_ENTITY.USER_ID AS KEYID
        from keycloak2.EVENT_ENTITY AS EVENT_ENTITY")
        ->pipe($this->dataStore("KEYKLOCKID"));
  }
}
