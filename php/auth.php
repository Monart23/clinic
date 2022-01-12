<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    header('Content-type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);

    if ($data) {
        $login = filter_var(trim($data['loginData']), FILTER_SANITIZE_STRING);
        $password = filter_var(trim($data['passwordData']), FILTER_SANITIZE_STRING);

    }
    try {
        $mysql = new mysqli('localhost','root','','bd_login');
        $result = $mysql->query("SELECT * FROM `doctors` WHERE `login`='$login' AND `pass`='$password'");
        $user = $result->fetch_assoc();
        if(is_null($user)){
            
            }else{
                setcookie('user', $user['login'], time()+3600, "/");
                echo "asdasd";
            }

        $mysql->close();
        http_response_code(201);
        echo $user;
    } catch (mysqli_sql_exception $e) {
        http_response_code(500);
        echo $e;
    }

?>