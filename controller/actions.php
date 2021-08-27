<?php 

foreach (glob("../functions/*.php") as $filename)
{
    include $filename;
}


header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type, application/json");
header("Access-Control-Allow-Credentials: true");



if(isset($_GET['action'])){
    $action = $_GET['action'];

    if($action == "user"){
        getUser();
    }

}else{
    $post = file_get_contents ('php://input');
    $post = json_decode($post, true);
    
    //echo json_encode($post);
    
    if($post['action'] != ""){
        $action = $post['action'];
    
        if($action == "register"){
    
            $name = $post['name'];
            $email = $post['email'];
            $password = $post['password'];
    
            registerUser($name, $email, $password);  
        }
    
        if($action == "login"){
            
            $email = $post['email'];
            $password = $post['password'];
    
            login($email, $password);  
        }
    
        if($action == "user"){
    
            getUser();  
        }
    }
}








?>