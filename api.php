<?php
    error_reporting( E_ALL );
    ini_set( 'display_errors', 1 );

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "solar";

    // Create connection
    $sqlConnect = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$sqlConnect) {
        die("Connection failed: " . mysqli_connect_error());
    }

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    function Secure($string) {
        global $sqlConnect;
        $string = trim($string);
        $string = mysqli_real_escape_string($sqlConnect, $string);
        $string = htmlspecialchars($string, ENT_QUOTES);
        return $string;
    }
    
    $returnData = [];
    $is_error = false;

    function msg($success,$status,$message,$extra = []){
        return array_merge([
            'success' => $success,
            'status'  => $status,
            'message' => $message
        ],$extra);
    }
    
    $data = $_GET;

    if(!$is_error) {
        $required_fields = array(
            'ammonia',
            'current',
            'humidity',
            'leakage',
            'pv',
            'temperature',
            'voltage'
        );
        foreach ($data as $key => $value) {
            if(array_search($key, $required_fields) === false) {
                $error_message = $key . ' not allowed; Allowed Fields are';
                $fields = array("fields" => implode(", ", $required_fields));

                $returnData = msg(0,422,$error_message,$fields);
                $is_error = true;
                break;
            } else {
                $data[$key] = Secure($value);
                if(!is_numeric($data[$key]) || empty($data[$key])) {
                    $error_message = $key . ' field has invalid data';
                    $returnData = msg(0,422,$error_message);
                    $is_error = true;
                    break;
                }
            }
        }
    }

    $date = date("Y-m-d");
    $time = date("h:i:s");

    if(!$is_error) {
        foreach ($data as $key => $value) {
            if($key == 'pv') {
                continue;
            } else if($key == 'current' || $key == 'voltage') {
                if(isset($data["pv"])) {
                    $pv = $data["pv"];
                    $sql = "SELECT * FROM `PV` WHERE `name` LIKE '{$pv}'";
                    $result = mysqli_query($sqlConnect, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $pvID = $row["id"];
                    } else {
                        mysqli_query($sqlConnect, "INSERT INTO `PV` (`name`) VALUES ('{$pv}')");
                        $pvID = mysqli_insert_id($sqlConnect);
                    }
                    mysqli_query($sqlConnect, "INSERT INTO `{$key}` (`value`, `pv`, `date`, `time`) VALUES ('{$value}', '{$pvID}', '{$date}', '{$time}')");
                }
            } else {
                mysqli_query($sqlConnect, "INSERT INTO `{$key}` (`value`, `date`, `time`) VALUES ('{$value}', '{$date}', '{$time}')");
            }
        }     
    }
    $returnData = [
        'success' => 1,
        'message' => 'You have successfully Updated.',
    ];
    mysqli_close($sqlConnect);

    echo json_encode($returnData);