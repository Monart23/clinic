<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    header('Content-type: application/json');
    include 'config.php';

    $data = json_decode(file_get_contents('php://input'), true);
    
    if ($data) {
        $complaint = addslashes(($data['complaintData']));
        $FIO = addslashes(($data['fioData']));
        $email = addslashes(trim($data['emailData']));
        $number = addslashes(trim($data['numberData']));

        try {
            $mysql = new mysqli($host, $admin, $adminpass, 'bd_complaints');
            $mysql->query("INSERT INTO `patient` (`FIO`, `email`, `number`, `complaint`) VALUES('$FIO', '$email', '$number', '$complaint')");
            $mysql->close();
            
            http_response_code(201);
        } catch (mysqli_sql_exception $e) {
            http_response_code(500);
            echo $e;
        }
    }

?>