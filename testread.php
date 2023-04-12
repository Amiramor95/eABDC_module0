<?php

$str = file_get_contents('./app_status.json');
        $json = json_decode($str, true); 
        $dbConnected = $json['isDBConnected'];

        if ($dbConnected) {
            echo 'aa';
        }
        

        ?>