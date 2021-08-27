<?php
require_once("../config.php");
require_once('../vendor/autoload.php');
use Firebase\JWT\JWT;

function deletePost($post_id){

    if(authenticateUser()){
        $jwt = $_COOKIE['jwt'];

        $decoded = JWT::decode($jwt, SECRET_KEY, array('HS256'));
        $result = (array)$decoded;
        $userInfo = (array)$result['data'];
        $author_id = $userInfo['id'];

        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die(mysqli_error($conn));

        $sql = $conn->query("DELETE FROM posts WHERE id = $post_id AND author_id = $author_id");

        if($sql){
            if($conn->affected_rows != 0){
                $response=array(
                    "status" => "success",
                    "message" => "post removed"
                );
                
                echo json_encode($response);
                return;
            }else{
                $response = setErr(500, "fail", "failed to remove post");
                echo json_encode($response);
                return;
            }
            
        }else{
            $response = setErr(500, "fail", "failed to remove post");
            echo json_encode($response);
            return;
        }

    }else{
        $response = setErr(401, "fail", "unauthenticated");
        echo json_encode($response);
        return;
    }

}


?>