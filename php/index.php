<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    header('Content-type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);
    
    if ($data) {
        $complaint = filter_var(trim($data['complaintData']), FILTER_SANITIZE_STRING);
        $FIO = filter_var(trim($data['fioData']), FILTER_SANITIZE_STRING);
        $email = filter_var(trim($data['emailData']), FILTER_VALIDATE_EMAIL);
        $number = filter_var(trim($data['numberData']), FILTER_SANITIZE_STRING);

        try {
            $mysql = new mysqli('localhost','root','','bd_complaints');
            $mysql->query("INSERT INTO `patient` (`FIO`, `email`, `number`, `complaint`) VALUES('$FIO', '$email', '$number', '$complaint')");
            $mysql->close();
            
            http_response_code(201);
        } catch (mysqli_sql_exception $e) {
            http_response_code(500);
            echo $e;
        }
    }

?>