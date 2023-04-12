<?php
namespace App\Reports;
class AdminUserListReportPDF extends \koolreport\KoolReport
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
        ->query("Select USER.USER_ID AS USER_ID,USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL
        from admin_management.USER AS USER order by USER_ID asc")
        ->pipe($this->dataStore("FIMMUSER"));

        $this->src("mysql")
        ->query("Select USER.USER_ID AS USER_ID,USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL,DISTRIBUTOR.DIST_NAME AS COMPANY
        from distributor_management.USER AS USER
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = USER.USER_DIST_ID 
        order by USER_ID asc")
        ->pipe($this->dataStore("DISTRIBUTORUSER"));

        $this->src("mysql")
        ->query("Select USER.USER_ID AS USER_ID,USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL,DISTRIBUTOR.DIST_NAME AS COMPANY
        from consultant_management.USER AS USER
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = USER.USER_DIST_ID 
        order by USER_ID asc")
        ->pipe($this->dataStore("CONSULTANTUSER"));

        $this->src("mysql")
        ->query("Select USER.TP_USER_ID AS USER_ID,USER.TP_USER_FNAME AS USER_NAME,USER.TP_USER_EMAIL AS USER_EMAIL,TP_USER_COMPANY.TP_NAME AS COMPANY
        from funds_management.TP_USER AS USER
        LEFT JOIN funds_management.TP_USER_COMPANY AS TP_USER_COMPANY
        ON TP_USER_COMPANY.TP_USER_COMP_ID = USER.TP_COMP_ID
        order by USER.TP_USER_ID asc")
        ->pipe($this->dataStore("OTHERSUSER"));
  }
}
