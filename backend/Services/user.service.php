<?php

    include_once( __DIR__ . "/../connection.php");

    class UserService{

        private $Link;
        function __construct(){
            global $Link;
            $c = new Connection();
            $Link = $c->connect();
        }

        
        public function getUser($column =null , $val = null, $retorno = false, $last = false ){
            global $Link;

            $query = "SELECT * FROM user ";
            
            if($column == 'id' ){
                $query = "SELECT * FROM user where id = '$val' ";                
            }
            if($column != 'id' && $column != null ){
                $query = "SELECT * FROM user where $column like '%$val%' ";                
            }

            $run = $Link->prepare($query);
            try {
                $run->execute();
            } catch ( PDOException $e) {
            echo json_encode([
                    "Message"=> "Error with QUERY",
                    "ERROR" => $e->getMessage()
                ]);
                die;
            }

            $result = $run->fetchAll(PDO::FETCH_ASSOC);
            if($retorno){
                return  sizeof($result) == 0 ;
            }
            if ($last) {
                echo ( end($result)['id']);
                // die;
            }else{
                echo json_encode($result);
            }
        }




        // ********** MUTAÇÃO DE DADOS UPDATE/INSERT/DELETE *******************

        public function mutateUser($user = null, $action, $column=null, $val = null, $id = null, $from_clie = false){
            global $Link;

            if($action == "insert"){
                $msg_success = "Successfull {user} INSERTED :)";
                $sql = "INSERT INTO user (name,email, password, birth_date, photo_url ) VALUES (:nam, :email, :pass, :birth, :photo)";                
            }
            if($action == "update"){
                $msg_success = "Successfull {user} UPDATED :)";
                
                if ($column != null && $val != null) {
                    $sql = "UPDATE user set  $column = '$val' where id = '$id' ";
                }else{
                    $sql = "UPDATE user set name= :nam ,email= :email, password= :pass, birth_date= :birth, photo_url= :photo where id = :id ";                
                    
                }
            }

            if ($action == "delete") {
                $msg_success = "Successfull {user} DELETED :)";
                if($id == null){
                    $this->messageSend("Request DELETE must have un id. Please try again with an id",400);
                    die;
                }
                $sql = "DELETE FROM user WHERE id= '$id' ";
            }

            $run = $Link->prepare($sql);

            if($action != "delete"){
                if ($column == null && $val == null  || $action == "insert" ) {
                    $action == "update" ?? $run->bindValue(":id", $user::$id) ;
                    $run->bindValue(":nam",   $user::$name);
                    $run->bindValue(":email", $user::$email);
                    $run->bindValue(":pass",  $user::$password);
                    $run->bindValue(":photo", $user::$photo_url);
                    $run->bindValue(":birth", $user::$birth_date);

                }
            }

            //    echo json_encode([
            //         "Message"=> $msg_success,
            //         "id" => $Link->lastInsertId() ?? null
            //     ]);
            //     die;

            try {
                $run->execute();

                if($from_clie == true ){
                       
                }else{
                    echo json_encode([
                        "Message"=> $msg_success,
                        "id" => $Link->lastInsertId() ?? 0 
                    ]);
                }
                                
                // die;

            } catch (PDOException $e) {
                return json_encode([
                    "Message"=> "Error with QUERY xx",
                    "ERROR" => $e->getMessage()
                ]);
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