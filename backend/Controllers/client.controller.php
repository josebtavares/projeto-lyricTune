<?php
    include_once( __DIR__ . "/../Models/client.model.php");
    include_once( __DIR__ . "/../Services/client.service.php");
    include_once( __DIR__ . "/../connection.php");

    // include_once("client.controller.php");
    include_once("user.controller.php");
    
    class ClientController{

        // ******************* GET USERS BY DIFERENT WAYS ********************** 
        public function getAll(){
            $Service = new ClientService();
            $Service->getClient();
        }
        
        public function getById($id){
            $Service = new ClientService();
            $Service->getClient('id', $id);
        }
        
        public function getByName($name){
            $Service = new ClientService();
            $Service->getClient('name', $name);
        }
        public function getByGmail($email){
            $Service = new ClientService();
            $Service->getClient('email', $email);
        }
        public function getByBirthday($date){
            $Service = new ClientService();
            $Service->getClient('date', $date);
        }

        // ******************* CREATE USER ********************** 
        
        public function getLast(){
            $con = new Connection();
            $Link = $con->Connect();
            $run = $Link->prepare("SELECT id from user ");
            $run->execute();
            $last = $run->fetchAll(PDO::FETCH_ASSOC);

            return end($last)['id'];
        }

        public function createClient($data){

            $ClientService = new ClientService();
            $userController = new UserController();
            $client = new client();

            $userController->createUser($data,true);
            $data = get_object_vars( json_decode($data) );                            
                       
            $client::$user_id       = $this->getLast();
            $client::$description   = $data['description'] ?? 'Hello there';      

            $ClientService->mutateClient($client,'insert',null, null ,null );

            die;
            
            
        }
        
        // ******************* UPDATE USER ********************** 
        public function updateClient($data,$mode,$target=null){
            
            $Service = new ClientService();
            $userController = new UserController();
            $client = new Client();
            $data_pure = $data;
            $data = get_object_vars( json_decode($data) );
            
            isset($data['user_id'])          ? $client::setUserId($data['user_id'])          : null;
            isset($data['description'])      ? $client::setDescription($data['description']) : null;

            isset($data['id'])          ? $client::setId($data['id'])              : null;
            isset($data['name'])        ? $client::setName($data['name'])          : null;
            isset($data['email'])       ? $client::setEmail($data['email'])        : null;
            isset($data['password'])    ? $client::setPassword($data['password'])  : null;
            isset($data['photo_url'])    ? $client::setPhoto_url($data['photo_url'])  : null;
            isset($data['birth_date'])  ? $client::setBirth($data['birth_date'])   : null;
            
            // ************* Caso atualizar todos os dados *************
            if($mode == "full"){    
                if(isset($data['id']) ){
                    if(!$Service->getClient("id", $data['id'], true) ){ // Vereficar se existe esse ID no DB
                        // messageSend("Porraaa! "); die;
                        // var_dump($data); die;
                        if($Service->updateClient($client)){
                            messageSend("UPDATE {client} succsessful ");
                        }
                    }else {         
                        $this->messageSend(" invalid ID :(",404);
                        die;        
                    }               
                }else{              
                    $this->messageSend("Request UPDATE must have un id. Please try again with an id",400);
                }
            
            // ********** Caso queira atualizar um campo em especifico  (EX:. name ) ******************* 
            }if($mode == "one"){
                if(isset($data['id']) ){
                    if(!$Service->getClient("id", $data['id'], true) ){ // Vereficar se existe esse ID no DB
                        if(isset($data[$target]) ){ // Vereficar se o CAMPO EXPECIFICO que quer editar é válida
                            if ($target == 'description' || $target == 'user_id' )  {
                                $Service->mutateClient($client,'update',$target,$data[$target],$data['id']);
                            }else{
                                $userController->updateUser($data_pure,'one',$target);
                                // $userService->mutateUser($user, 'update', $target, $data[$target], $data['id'] ); 
                            }
                        }else{
                            $this->messageSend("Request UPDATE must have un $target. Please try again with an $target",400);
                        }
                    }else{
                        $this->messageSend(" invalid ID :(",404);
                        die;
                    }
                    
                }else{
                    $this->messageSend("Request UPDATE must have un id. Please try again with an id",400);
                }
            }
            
        }


        public function deleteClientById($id){
            $Service = new ClientService();

            if ( !$Service->getClient("id", $id, true)  ){
                $Service->mutateClient(null,"delete",null,null,$id);
            }else{
                $this->messageSend(" invalid ID :(",404);
                die;
            }
        }

        private function messageSend($msg, $status = 200){
            http_response_code($status);
            echo json_encode([
                "mensagem" => $msg
            ]);
        } 
    }

?>




