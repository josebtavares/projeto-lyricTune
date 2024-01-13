<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    
    include_once( __DIR__ . "/../connection.php");
    include_once "token.php";

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
                
                if (isset( $result[0]  ) ) {
                $userData = $result[0];
                
                    $token = tokenGenerator($userData['id'], $userData['email'], $userData['name'], $userData['photo_url'], 432000 );
                    
                    $this->responseData($found,$token,200);
                }else{
                    $this->responseData($found,null, 200);
                }

               
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

        private function responseData($found,$token, $status = 200){
            http_response_code($status);
            echo json_encode([
                "status" => $status,
                "total" => $found,
                "token" => $token,
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
