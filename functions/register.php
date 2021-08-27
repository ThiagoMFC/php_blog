<?php 

require_once("../config.php");


function registerUser($name, $email, $password){

    $response = "";

    $name = strip_tags($name);
    $name = str_replace(' ', '_', $name);
    $name = ucfirst(strtolower($name));

    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    $password = strip_tags($password);
    $password = md5($password);

    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die(mysqli_error($conn));

    $sql = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if($sql){
        $row = $sql->fetch_array();
        if($row){
            $response = setErr(403, "fail", "email already exists");
            echo json_encode($response);
            return;
        }
    }
    //$response = "fail ".$sql. " ".$conn->error;
     

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

    if($conn->query($sql) === true){
        $response = setErr(200, "success", "user created");
    }else{
        $response = setErr(500, "fail", "failed to create user"); 
        //$response = "fail ".$sql. " ".$conn->error;
    }

    

    $conn->close();

    echo json_encode($response);
    return;
}

?>