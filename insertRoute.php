<?php
$servername = "192.168.2.67";
$username = "fimm_user_dev";
$password = "@Bcd1234";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";


        $str = file_get_contents('./getUIRoute.json');
        $json = json_decode($str, true);

        foreach ($json as $key=>$value) {

            $sql = "INSERT INTO admin_management.MANAGE_SCREEN (MANAGE_SUBMODULE_ID, SCREEN_NAME, SCREEN_ROUTE, SCREEN_DESCRIPTION)
            VALUES ('1', 'PLEASE RENAME','".$json[$key]['name']."', 'PLEASE RENAME')";

            if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }

        // echo $json[$key]['path'];
            // $module = new ManageScreen;
            // $module->MANAGE_SUBMODULE_ID = 1;
            // $module->SCREEN_NAME = 'PLEASE RENAME';
            // $module->SCREEN_ROUTE = $json[$key]['name'];
            // $module->SCREEN_DESCRIPTION = 'PLEASE RENAME';

            // $module->save();
        }

?>