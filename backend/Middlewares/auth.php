<?php

    include_once ( __DIR__ . "/../Services/auth.php");
    
    
    function Login($email = null, $pass = null){
        
        $method = $_SERVER['REQUEST_METHOD'];
        $data = file_get_contents("php://input");
        $data =  get_object_vars( json_decode($data) ) ;
        $uri = $_SERVER['REQUEST_URI'];
        $url_arr = explode('/',$uri);
        
        
        if ($method == "POST") {
            // echo $data['email']; die;
            // echo json_encode($data); die;
            
            if ($url_arr[2] == "login") {
            
                $service = new AuthService;
                $service->Login($data['email'], $data['password']);
            }
        
        }

    }


    


?>