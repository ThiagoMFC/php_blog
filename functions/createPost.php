<?php 
 require_once("../config.php");
 require_once('../vendor/autoload.php');
 use Firebase\JWT\JWT;

 function createPost($title, $body){

    if(authenticateUser()){
        $jwt = $_COOKIE['jwt'];

        $decoded = JWT::decode($jwt, SECRET_KEY, array('HS256'));
        $result = (array)$decoded;
        $userInfo = (array)$result['data'];
        $author_id = $userInfo['id'];
        $title = strip_tags($title);
        $body = strip_tags($body);

        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die(mysqli_error($conn));

        $sql = $conn->query("INSERT INTO posts(title, body, author_id) VALUES ('$title', '$body', $author_id)");

        if($sql){
            $response=array(
                "status" => "success",
                "message" => "post created"
            );
            
            echo json_encode($response);
            return;
        }else{
            $response = setErr(500, "fail", "failed to create post");
        }

    }else{
        $response = setErr(401, "fail", "unauthenticated");
        echo json_encode($response);
        return;
    }

 }

?>