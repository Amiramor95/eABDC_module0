<?php
namespace App\Reports;
class AdminUserLogReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;
    //use \koolreport\cloudexport\Exportable;
    function defaultParamValues()
    {
        //$StartingDate = mktime();
        $start_date = date('Y-m-d', strtotime('today'));
        $end_date = date('Y-m-d', strtotime('-1 years'));//date('Y-m-d', strtotime('last day of december this year'));
        return array(
            "MODULEID"=>1,
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
        );
    }
    function bindParamsToInputs()
    {
        return array(
            "MODULEID",
            "dateRange",
        );
    }
    function setup()
    {
        $query_params = array();
        $query_params1 = array();
        if($this->params["MODULEID"] != 0)
        {
            $query_params1[":MODULE_ID"] = $this->params["MODULEID"];
        }
        if(isset($this->params["dateRange"][0]))
        {
        $query_params[":start"] = $this->params["dateRange"][0];
        }
        if(isset($this->params["dateRange"][1]))
        {
        $query_params[":end"] = $this->params["dateRange"][1];
        }
        if($this->params["MODULEID"] == 1){
        $this->src("mysql")
        ->query("Select USER.USER_ID AS USER_ID,USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL,FIMM_USER_LOG.LOGIN_TIMESTAMP AS LOGINTIME,FIMM_USER_LOG.LOGOUT_TIMESTAMP AS LOGOUTTIME
        from admin_management.FIMM_USER_LOG AS FIMM_USER_LOG
        JOIN admin_management.USER AS USER
        ON USER.USER_ID = FIMM_USER_LOG.USER_ID
        where FIMM_USER_LOG.STATUS = 0
        ".(( $this->params["dateRange"][0]?"and FIMM_USER_LOG.LOGIN_TIMESTAMP <= :start":""))."
        ".(( $this->params["dateRange"][1]?"and FIMM_USER_LOG.LOGIN_TIMESTAMP >= :end":""))." 
        order by FIMM_USER_LOG.LOGIN_TIMESTAMP desc")
        ->params($query_params)
        ->pipe($this->dataStore("FIMMUSERLOG"));
     }
     if($this->params["MODULEID"] == 2){
        $this->src("mysql")
        ->query("Select USER.USER_ID AS USER_ID,USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL,DISTRIBUTOR_USER_LOG.LOGIN_TIMESTAMP AS LOGINTIME,DISTRIBUTOR_USER_LOG.LOGOUT_TIMESTAMP AS LOGOUTTIME,DISTRIBUTOR.DIST_NAME AS COMPANY
        from admin_management.DISTRIBUTOR_USER_LOG AS DISTRIBUTOR_USER_LOG
        JOIN distributor_management.USER AS USER
        ON USER.USER_ID = DISTRIBUTOR_USER_LOG.USER_ID
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = USER.USER_DIST_ID
        where DISTRIBUTOR_USER_LOG.STATUS = 0
        ".(( $this->params["dateRange"][0]?"and DISTRIBUTOR_USER_LOG.LOGIN_TIMESTAMP <= :start":""))."
        ".(( $this->params["dateRange"][1]?"and DISTRIBUTOR_USER_LOG.LOGIN_TIMESTAMP >= :end":""))." 
        order by DISTRIBUTOR_USER_LOG.LOGIN_TIMESTAMP desc")
        ->params($query_params)
        ->pipe($this->dataStore("DISTRIBUTORUSERLOG"));
     }

     if($this->params["MODULEID"] == 3){
        $this->src("mysql")
        ->query("Select USER.USER_ID AS USER_ID,USER.USER_NAME AS USER_NAME,USER.USER_EMAIL AS USER_EMAIL,CONSULTANT_USER_LOG.LOGIN_TIMESTAMP AS LOGINTIME,CONSULTANT_USER_LOG.LOGOUT_TIMESTAMP AS LOGOUTTIME,DISTRIBUTOR.DIST_NAME AS COMPANY
        from admin_management.CONSULTANT_USER_LOG AS CONSULTANT_USER_LOG
        JOIN consultant_management.USER AS USER
        ON USER.USER_ID = CONSULTANT_USER_LOG.USER_ID
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = USER.USER_DIST_ID
        where CONSULTANT_USER_LOG.STATUS = 0
        ".(( $this->params["dateRange"][0]?"and CONSULTANT_USER_LOG.LOGIN_TIMESTAMP <= :start":""))."
        ".(( $this->params["dateRange"][1]?"and CONSULTANT_USER_LOG.LOGIN_TIMESTAMP >= :end":""))." 
        order by CONSULTANT_USER_LOG.LOGIN_TIMESTAMP desc")
        ->params($query_params)
        ->pipe($this->dataStore("CONSULTANTUSERLOG"));
     }
     if($this->params["MODULEID"] == 4){
        $this->src("mysql")
        ->query("Select USER.TP_USER_ID AS USER_ID,USER.TP_USER_FNAME AS USER_NAME,USER.TP_USER_EMAIL AS USER_EMAIL,OTHERS_USER_LOG.LOGIN_TIMESTAMP AS LOGINTIME,OTHERS_USER_LOG.LOGOUT_TIMESTAMP AS LOGOUTTIME,TP_USER_COMPANY.TP_NAME AS COMPANY
        from admin_management.OTHERS_USER_LOG AS OTHERS_USER_LOG
        JOIN funds_management.TP_USER AS USER
        ON USER.TP_USER_ID = OTHERS_USER_LOG.USER_ID
        LEFT JOIN funds_management.TP_USER_COMPANY AS TP_USER_COMPANY
        ON TP_USER_COMPANY.TP_USER_COMP_ID = USER.TP_COMP_ID
        where OTHERS_USER_LOG.STATUS = 0
        ".(( $this->params["dateRange"][0]?"and OTHERS_USER_LOG.LOGIN_TIMESTAMP <= :start":""))."
        ".(( $this->params["dateRange"][1]?"and OTHERS_USER_LOG.LOGIN_TIMESTAMP >= :end":""))." 
        order by OTHERS_USER_LOG.LOGIN_TIMESTAMP desc")
        ->params($query_params)
        ->pipe($this->dataStore("OTHERSUSERLOG"));
     }

        $this->src("mysql")
        ->query("Select EVENT_ENTITY.IP_ADDRESS AS IP,EVENT_ENTITY.USER_ID AS KEYID
        from keycloak2.EVENT_ENTITY AS EVENT_ENTITY")
        ->pipe($this->dataStore("KEYKLOCKID"));

        $this->src("mysql")
      ->query("select MAIN_MODULE.MODULEID AS MODULEID,MAIN_MODULE.MODULENAME AS MODULENAME
      from admin_management.MAIN_MODULE AS MAIN_MODULE
      where MAIN_MODULE.STATUS = 1
      ")
      ->pipe($this->dataStore("MAINMODULE"));
  }
}
