<?php
use \koolreport\widgets\koolphp\Table;
?>
<html>
    <head>
    <title>My Report</title>
    </head>
    <body>
        <h1>It works 
        <a href="<?php echo config('app.koolreport_server_url');?>/myreportpdf" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
    
    </h1>
        <?php
        Table::create([
            "dataSource"=>$this->dataStore("offices")
        ]);
        ?>
    </body>
</html>

