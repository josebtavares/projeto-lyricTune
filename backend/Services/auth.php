<?php

    include_once( __DIR__ . "/../connection.php");

    class AuthService{

        private $Link;
        function __construct(){
            global $Link;
            $c = new Connection();
            $Link = $c->connect();
        }

        public function Login($email = null, $password = null ){
            global $Link;
            
            $sql = "SELECT * from user inner join client on user.email = :email and
             user.password = :pass where user.id = client.user_id ";

            $run = $Link->prepare($sql);
            $run->bindValue(":email", $email );
            $run->bindValue(":pass",  $password );

            try {
                $run->execute();
                // return true;
                $result = $run->fetchAll(PDO::FETCH_ASSOC);
                $found = $run->rowCount();
                $this->responseData($found,$result,200);
               
            } catch (PDOException $e) {
                echo json_encode([
                    "Message"=> "Error with SQL",
                    "ERROR" => $e->getMessage()
                ]);
                die;
            }

        }





        
        // public function delateClient($id){

        // }

        private function responseData($found,$data, $status = 200){
            http_response_code($status);
            echo json_encode([
                "status" => $status,
                "total" => $found,
                "data" => $data,
            ]);
        } 
        private function messageSend($msg, $status = 200){
            http_response_code($status);
            echo json_encode([
                "mensagem" => $msg
            ]);
        } 
    }

?>