<?php

function find_line_number_by_string($controllersfile, $search, $case_sensitive = false)
{

    $line_number = [];
    if ($file_handler = fopen('test.txt', "r")) {
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

$content = file('test.txt');

$count = 0;

foreach ($output as $d) {

    foreach ($content as $line_num => $line) {
        if (false === (strpos($line, '//Users test'))) {
            continue;
        }

        $content[$line_num] = "\$validator = Validator::make(\$request->all(), [ //" . $count . "\n";

        break;
        // echo $line_num;
    }

    // echo $count;
    file_put_contents('test.txt', implode($content));
    // break;
    $count++;
}
$count = $count - 1;
// break;
$config = 'test.txt';

$date = date("F j, Y");
$time = date("H:i:s");

$username = "user";
$password = "pass";
$email = "email";
$newline = "";
$newuser = $username . " " . $password . " " . $email . " " . $date . " " . $time . "\r\n"; // I added new line after new user
$newuser.= $username . " " . $password . " " . $email . " " . $date . " " . $time . "\r\n"; // I added new line after new user

$insertPos = 0; // variable for saving //Users position

for ($x = 0; $x <= $count; $x++) {
    $file = fopen($config, "r+") or exit("Unable to open file!");
    while (!feof($file)) {
        $linex = fgets($file);
        if (strpos($linex, "\$validator = Validator::make(\$request->all(), [ //" . $x) !== false) {
            $insertPos = ftell($file); // ftell will tell the position where the pointer moved, here is the new line after //Users.
            $newline = $newuser;
            // echo $insertPos;
        } else {
            $newline .= $linex; // append existing data with new data of user
        }
    }
    fseek($file, $insertPos); // move pointer to the file position where we saved above
    fwrite($file, $newline);

    fclose($file);
}

$content = file('test.txt');

foreach ($content as $line_num => $line) {
    if (false === (strpos($line, '$validator = Validator::make($request->all(), ['))) {
        continue;
    }

    $content[$line_num] = "\$validator = Validator::make(\$request->all(), [ \n";

    // echo $line_num;
}

// echo $count;
file_put_contents('test.txt', implode($content));