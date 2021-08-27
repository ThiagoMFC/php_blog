<?php 
require_once("../config.php");
require_once('../vendor/autoload.php');
 use Firebase\JWT\JWT;

function getUser(){
    //$secret_key = "YOUR_SECRET_KEY";

    if(isset($_COOKIE['jwt'])){
        $jwt = $_COOKIE['jwt'];

        $decoded = JWT::decode($jwt, SECRET_KEY, array('HS256'));
        $result = (array)$decoded;
        $userInfo = (array)$result['data'];
        $id = $userInfo['id'];
        $email = $userInfo['email'];
        $name = $userInfo['name'];

        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die(mysqli_error($conn));
        $sql = $conn->query("SELECT * FROM users WHERE id = $id AND email = '$email' AND name = '$name'");
        if($sql){
            $row = $sql->fetch_array();
            if($row){
                $response=array(
                    "status" => "success",
                    "message" => "user found",
                    "data" => $row
                );
                
                echo json_encode($response);
                return;
            }
        }else{
            $response = setErr(500, "fail", "");
        
            echo json_encode($response);
            return; 
        }
        $conn->close();
        
    }else{
        $response = setErr(401, "fail", "unauthenticated");
        
        echo json_encode($response);
        return;
    }


    
}

?>