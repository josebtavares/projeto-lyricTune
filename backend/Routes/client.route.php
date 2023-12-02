<?php

    require ( __DIR__ . "/../controllers/client.controller.php");

    $method = $_SERVER['REQUEST_METHOD'];
    $ClientController = new ClientController();
    $data = file_get_contents("php://input");

    $uri = $_SERVER['REQUEST_URI'];

    $url_arr = explode('/',$uri);
    
    array_shift($url_arr);

    // echo ($uri);
    // die;
    
    if (isset($url_arr[1])){

    if ( $url_arr[1]  == 'client' ) {

        if($method == "GET"){

            if ( $uri == '/api/client' || $uri == '/api/client/' ) {   
                $ClientController->getAll();
                // messageSend("Ver tudos");
            }
            
            if (isset($url_arr[2]) && !isset($url_arr[3]) ) {
                if($url_arr[2] != ''){
                    $ClientController->getById($url_arr[2]);                
                }
            }
            
            // Para busca de clients com base em outros fatores
            if( stripos( $uri , '/api/client/search') !== false  ){ 
                if(isset($url_arr[4]) ){    
                    if( $url_arr[3] == 'name'  ){ 
                        $ClientController->getByName($url_arr[4]);
                    }  
                    if( $url_arr[3] == 'email'  ){ 
                        $ClientController->getByGmail($url_arr[4]);
                    }  
                    if( $url_arr[3] == 'birthday' ){ 
                        $ClientController->getByBirthday($url_arr[4]);
                    }
                    if( $url_arr[3] != 'birthday' && $url_arr[3] != 'email' && $url_arr[3] != 'name'){
                        messageSend("Wrong paramter's name! ",400);
                        die;
                    } 
                }else{
                    messageSend("Not enough paramter! ",400);
                    die;
                }  
            }
        }

        if($method == "POST"){
            if( stripos( $uri , '/api/client/create') !== false  ){ 
                $ClientController->createClient($data);  
                // messageSend("Route {create} out of service. Please try later!",404);
            }     
                 
        }


        if($method == "PUT"){
            if( stripos( $uri , '/api/client/update') !== false && !isset($url_arr[3])  ){ 
                $ClientController->updateClient($data,"full"); 
                // messageSend("Route {update multi } out of service. Please try later!",404);  
            }
            if( stripos( $uri , '/api/client/update') !== false && isset($url_arr[3]) ){
                messageSend("Route {update one } out of service. Please try later!",404); 
            }
        }


        if($method == "DELETE"){
            if( stripos( $uri , '/api/client/delete') !== false ){ 
                if (isset($url_arr[3])) {
                    $ClientController->deleteClientById( $url_arr[3] );
                    // messageSend("Route { delete } out of service. Please try later!",404);   
                }
            }
        }
    } 

    
}

 ?>



