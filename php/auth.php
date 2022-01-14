<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    header('Content-type: application/json');
    include 'config.php';

    $data = json_decode(file_get_contents('php://input'), true);
    
    if ($data) {
        $login = filter_var(trim($data['login']), FILTER_SANITIZE_STRING);
        $password = $data['password'];
    }
    try {
        $mysql = new mysqli($host, $admin ,$adminpass,'bd_login');
        $result = $mysql->query("SELECT COUNT(*) FROM doctors WHERE login='$login' AND pass='$password'");
        $user = mysqli_fetch_assoc($result);
        #echo user[0];
        #print_r(user);
        if(!is_null($user)){
          
            if(is_countable($user) && count($user) == 0){
                    #echo "Нет такого пользователя\n";
                    exit();
                }else{
                    #echo "Пользователь найден успешно\n";
                     session_start();
                     setcookie("user", $login, time()+30, "/");
                     $_SESSION['id'] = $login;
                     #setcookie("user", $user);
                     #echo $_COOKIE["user"];
                }
            $mysql->close();
            http_response_code(202);
        }else http_response_code(501);
    } catch (mysqli_sql_exception $e) {
            http_response_code(500);
            echo $e;
}
    
?>