<?php 

function setErr($code, $status, $message){
    http_response_code($code);
    $response = array(
        "status" => $status,
        "message" => $message
    );

    return $response;
}

?>