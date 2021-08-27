<?php 
 require_once("../config.php");
 require_once('../vendor/autoload.php');
 use Firebase\JWT\JWT;

 

 function login($email, $password){

    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    $password = strip_tags($password);
    $password = md5($password);

    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die(mysqli_error($conn));

    $sql = $conn->query("SELECT id, name, email FROM users WHERE email = '$email' AND password = '$password'");
    if($sql){
        $row = $sql->fetch_array();
        if($row){


            //$secret_key = "YOUR_SECRET_KEY"; //should be long, binary string, store it in a configuration file but for practice this is ok
            $issuer_claim = "THE_ISSUER"; // this can be the servername
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 10; //not before in seconds
            $expire_claim = $issuedat_claim + 86400; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $row['id'],
                    "name" => $row['name'],
                    "email" => $row['email'])
                );

            $jwt = JWT::encode($token, SECRET_KEY);
            
            setcookie("jwt", $jwt, time() + (86400), "/");

            http_response_code(200);
            
            $response=array(
                "status" => "success",
                "message" => "user found",
                "id"=> $row['id'],
                "name" => $row['name'],
                "email" => $row['email']
            );
            
            echo json_encode($response);
            return;
        }else{
            $response = setErr(404, "fail", "wrong email or password");
        }
    }
    $conn->close();
    echo json_encode($response);
    return;
 }

?>