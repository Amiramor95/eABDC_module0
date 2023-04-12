<?php
// try {
//     $conn = new PDO('mysql:host=192.168.2.56:6000;dbname=module0', 'fimm_user', 'fimm_db890!@#');
// } catch (PDOException $e) {

//     http_response_code(400);
//     $r = new response();
//     $r->result = "Connection Failed";
//     $r->reason = "Error to connect to server. Please Contact FiMM technical support";
//     echo json_encode($r);
//     exit();

// }

function find_line_number_by_string($controllersfile, $search, $case_sensitive = false)
{

    // echo $search;
    $line_number = [];
    if ($file_handler = fopen($controllersfile, "r")) {
        $i = 0;
        while ($line = fgets($file_handler)) {
            $i++;
            //case sensitive is false by default
            if ($case_sensitive == false) {
                $search = strtolower($search); //convert file and search string
                $line = strtolower($line); //to lowercase
            }
            //find the string and store it in an array
            if (strpos($line, $search) !== false) {
                $line_number[] = $i;
            }
        }
        fclose($file_handler);
    } else {
        return "File not exists, Please check the file path or filename";
    }
    //if no match found
    if (!empty($line_number)) {

        return $line_number;
    } else {
        return "No match found";
    }
}

$output = find_line_number_by_string('test.txt', '//Users test');
$currentPos = 1;
foreach ($output as $line) {

    $f = fopen('test.txt', "r+");

    $oldstr = file_get_contents('test.txt');
    $str_to_insert = "Write the string to insert here";
    $specificLine = $line;

// read lines with fgets() until you have reached the right one
    //insert the line and than write in the file.

    while (($buffer = fgets($f)) !== false) {
        echo $buffer.'ss';
        if (strpos($buffer, $specificLine) !== false) {
            
            $pos = ftell($f);
            $newstr = substr_replace($oldstr, $str_to_insert, $pos, 0);
            file_put_contents('test.txt', $newstr);
            break;
        }
    }
    fclose($f);
    // $line++;
    // $config = 'test.txt';
    // $file=fopen($config,"r+") or exit("Unable to open file!");

    // $date = date("F j, Y");
    // $time = date("H:i:s");

    // $username = "user";
    // $password = "pass";
    // $email = "email";
    // $newline = "";
    // $newuser = $username . " " . $password . " " . $email . " " . $date . " " .    $time."\r\n";   // I added new line after new user
    // $insertPos=0;  // variable for saving //Users position
    // // $currentPos = 1;
    // $sama = false;
    // while (!feof($file)) {
    //     $line=fgets($file);
    //     if (strpos($line, '//Users test')!==false) {
    //         $insertPos=ftell($file);    // ftell will tell the position where the pointer moved, here is the new line after //Users.
    //         echo $insertPos.'ss';
    //         if($currentPos == $insertPos){
    //             echo 'sx';
    //             $sama = true;
    //             break;
    //         }
    //         $newline =  $newuser;
    //     } else {
    //         $newline.=$line;   // append existing data with new data of user
    //     }

    //     $currentPos = $insertPos;
    // }

    // if(!$sama){
    //     fseek($file,$currentPos);   // move pointer to the file position where we saved above
    //     fwrite($file, $newline);

    //     fclose($file);
    // }

}
