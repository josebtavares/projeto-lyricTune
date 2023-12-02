<?php

    require ( __DIR__ . "/../controllers/user.controller.php");

    $method = $_SERVER['REQUEST_METHOD'];
    $Controller = new UserController();
    $data = file_get_contents("php://input");

    $uri = $_SERVER['REQUEST_URI'];

    $url_arr = explode('/',$uri);
    
    array_shift($url_arr);

    // echo ($uri);
    // die;
    
    if (isset($url_arr[1])){

        // messageSend($url_arr[1]);die;
        if ( $url_arr[1]  == 'user' ) {

            if($method == "GET"){
                if ( $uri == '/api/user' || $uri == '/api/user/' ) {   
                    $Controller->getAll();
                    die;
                }
                
                if (isset($url_arr[2]) && !isset($url_arr[3]) ) {
                    if($url_arr[2] != ''){
                        $Controller->getById($url_arr[2]);
                        die;                
                    }
                }
                
                // Para busca de users com base em outros fatores
                if( stripos( $uri , '/api/user/search') !== false  ){ 
                    if(isset($url_arr[4])){
                        if( $url_arr[3] == 'name' ){
                            // if($url_arr[3] != ''){
                                $Controller->getByName($url_arr[4]);
                            // }
                        }
                        if( $url_arr[3] == 'email' ){
                            // if($url_arr[3] != ''){
                                $Controller->getByGmail($url_arr[4]);
                            // }
                        }
                        if( $url_arr[3] == 'birth_date'  ){
                            // if($url_arr[3] != ''){
                                $Controller->getByBirthday($url_arr[4]);
                            // }
                        }
                        if($url_arr[3] != 'birth_date' && $url_arr[3] != 'email' && $url_arr[3] != 'name'){
                            messageSend("Wrong paramter's name! ",400);
                            die;
                        }
                    }else{
                        messageSend("Not enough paramter! ",400);
                        die;
                    } 
                }
                else{
                    messageSend("Route not valid",404);
                }
            }

            if($method == "POST"){
                if( stripos( $uri , '/api/user/create') !== false  ){ 
                    $Controller->createUser($data);   
                }     
                    
            }


            if($method == "PUT"){
                if( stripos( $uri , '/api/user/update') !== false && !isset($url_arr[3])  ){ 
                    $Controller->updateUser($data,"full");   
                }
                if( stripos( $uri , '/api/user/update') !== false && isset($url_arr[3]) ){
                    $Controller->updateUser($data,"one",$url_arr[4]);   
                }
            }


            if($method == "DELETE"){
                if( stripos( $uri , '/api/user/delete') !== false ){ 
                    if (isset($url_arr[3])) {
                        $Controller->deleteUserById( $url_arr[4]);   
                    }
                }
            }
            
        }

    }


    function messageSend($msg, $status = 200){
        http_response_code($status);
        echo json_encode([
            "mensagem" => $msg
        ]);
    }

 ?>



