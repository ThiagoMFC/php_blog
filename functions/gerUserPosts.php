<?php
 require_once("../config.php");

function getUserPosts($id){
    $hasRow = false;
    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die(mysqli_error($conn));
    $sql = $conn->query("SELECT * FROM posts WHERE author_id = $id");
    if($sql){
        while($row = $sql->fetch_array(MYSQLI_ASSOC)){
            $response[]= $row;
            $hasRow = true;
        }

        if($hasRow){
            echo json_encode($response);
        }else{
            $response = setErr(500, "fail", "");
    
            echo json_encode($response);
        }

        

    }else{
        $response = setErr(500, "fail", "");
    
        echo json_encode($response);

    }
    $conn->close();
   
}

?>