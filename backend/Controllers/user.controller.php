<?php
    include_once( __DIR__ . "/../Models/user.model.php");
    include_once( __DIR__ . "/../Services/user.service.php");
    
    class UserController{

        // ******************* GET USERS BY DIFERENT WAYS ********************** 
        public function getAll(){
            $Service = new UserService();
            $Service->getUser();
        }
         
        public function getById($id){
            $Service = new UserService();
            $Service->getUser('id', $id);
        }
        
        public function getByName($name){
            $Service = new UserService();
            $Service->getUser('name', $name);
        }
        public function getByGmail($email){
            $Service = new UserService();
            $Service->getUser('email', $email);
        }
        public function getByBirthday($date){
            $Service = new UserService();
            $Service->getUser('date', $date);
        }

        // ******************* CREATE USER ********************** 
        public function createUser($data, $from_cli = false){
            $Service = new UserService();
            $user = new User();
            $data = get_object_vars( json_decode($data) );
            
            // --- Faz com que o avatar do user seja uma imagem por defeito ---- 
            if(!isset($data['photo_url'])){
                $avatar = "https://i.ibb.co/xFFfc2N/default-profile-img.jpg";
            }else{
                if ($data['photo_url'] == '0') {
                    $avatar = "https://i.ibb.co/xFFfc2N/default-profile-img.jpg";
                }else{
                    $avatar = $data['photo_url'];
                }
            }
            
            if(isset($data['name']) && isset($data['email']) && isset($data['password']) ){
                
                // echo json_encode( $data );
                $user::setAll($data['name'],$data['email'],$data['password']);
                $user::setBirth($data['birth_date']);  
                $user::setPhoto_url($avatar);  
                $Service->mutateUser($user, 'insert',null,null,null, $from_cli);
            }else{
                echo json_encode([
                    "Message" => "Not enough data"
                ]);
            }
        }
        
        // ******************* UPDATE USER ********************** 
        public function updateUser($data,$mode,$target=null){
            
            $Service = new UserService();
            $user = new User();
            $data = get_object_vars( json_decode($data) );

            isset($data['id'])          ? $user::setId($data['id'])              : null;
            isset($data['name'])        ? $user::setName($data['name'])          : null;
            isset($data['email'])       ? $user::setEmail($data['email'])        : null;
            isset($data['password'])    ? $user::setPassword($data['password'])  : null;
            isset($data['birth_date'])  ? $user::setBirth($data['birth_date'])   : null;

            // ************* Caso atualizar todos os dados *************
            if($mode == "full"){
                if(isset($data['id']) ){
                    if(!$Service->getUser("id", $data['id'], true) ){ // Vereficar se existe esse ID no DB
                        // var_dump($user::$name); die;
                        $Service->mutateUser($user, 'update');
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
                    if(!$Service->getUser("id", $data['id'], true) ){ // Vereficar se existe esse ID no DB
                        if(isset($data[$target]) ){ // Vereficar se o CAMPO EXPECIFICO que quer editar é válida
                            $Service->mutateUser($user, 'update', $target, $data[$target], $data['id'] ); 
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


        public function deleteUserById($id){
            $Service = new UserService();

            if ( !$Service->getUser("id", $id, true)  ){
                $Service->mutateUser(null,"delete",null,null,$id);
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




