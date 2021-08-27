<?php
 require_once("../config.php");
 require_once('../vendor/autoload.php');
 use Firebase\JWT\JWT;

 function authenticateUser(){
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
                
                return true;
            }
        }else{
            return false; 
        }
        $conn->close();
        
    }else{
        return false;
    }
 }

?>