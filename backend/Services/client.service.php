<?php

    include_once( __DIR__ . "/../connection.php");

    class ClientService{

        private $Link;
        function __construct(){
            global $Link;
            $c = new Connection();
            $Link = $c->connect();
        }

        public function updateClient($client){
            global $Link;
            
            $sql = "UPDATE `client` INNER JOIN user on client.user_id = user.id 
                set user.name = :name, user.email = :email, user.password = :pass,
                user.photo_url = :photo, user.birth_date = :birth, client.description = :description
                where client.id = :id";

            // $client::getAll();
            //  die;
            $run = $Link->prepare($sql);
            $run->bindValue(":id",    $client::$id );
            $run->bindValue(":name",   $client::$name );
            $run->bindValue(":email", $client::$email );
            $run->bindValue(":pass",  $client::$password );
            $run->bindValue(":photo", $client::$photo_url );
            $run->bindValue(":description", $client::$description );
            $run->bindValue(":birth", $client::$birth_date );

            try {
                $run->execute();
                return true;
            } catch (PDOException $e) {
                echo json_encode([
                    "Message"=> "Error with SQL",
                    "ERROR" => $e->getMessage()
                ]);
                die;
            }

        }





        public function getClient($column =null , $val = null, $retorno = false ){
            global $Link;

            $query = "SELECT client.id ,client.user_id, user.name, user.email,
             user.password, user.photo_url, user.token,user.birth_date,
             user.register_date, client.description
             FROM user inner join client where user.id = client.user_id  ";
            
            if($column == 'id' ){
                $query = "SELECT client.id ,client.user_id, user.name, user.email,
                user.password, user.photo_url, user.token,user.birth_date,
                user.register_date, client.description
                FROM user inner join client where user.id = client.user_id  and client.id = '$val' ";
                
            }
            if($column != 'id' && $column != null ){
                $query = "SELECT client.id ,client.user_id, user.name, user.email,
                user.password, user.photo_url, user.token,user.birth_date,
                user.register_date, client.description
                FROM user inner join client where user.id = client.user_id  and user.$column like '%$val%' ";
            }

            $run = $Link->prepare($query);
            try {
                $run->execute();
            } catch ( PDOException $error) {
                    echo json_encode([
                        "Message"=> "Error with QUERY",
                        "ERROR" => $error->getMessage()
                    ]);
                    die;
            }

            $result = $run->fetchAll(PDO::FETCH_ASSOC);
            if($retorno){
                return  sizeof($result) == 0 ;
            }
            echo json_encode($result);
            die;
        }


        // ********** MUTAÇÃO DE DADOS UPDATE/INSERT/DELETE *******************
        public function mutateClient($client = null, $action, $column=null, $val = null, $id = null){
            global $Link;

            // $exist = $this->getclient("email", $client::$email, true);

            // var_dump($exist);
            // die;

            if($action == "insert"){
                $msg_success = "Successfull Insert :)";
                $sql = "INSERT INTO client (user_id, description ) VALUES (:user_id, :descr)";                
            }
            if($action == "update"){
                $msg_success = "Successfull Update :)";
                if ($column != null && $val != null) {
                    $sql = "UPDATE client set  $column = '$val' where id = '$id' ";
                }else{
                    $sql = "UPDATE client set user_id= :user_id ,description= :descr where id = :id ";                
                }
            }

            if ($action == "delete") {
                $msg_success = "Successfull DELETE :)";
                if($id == null){
                    $this->messageSend("Request DELETE must have un id. Please try again with an id",400);
                    die;
                }
                $sql = "DELETE FROM client WHERE id= '$id' ";
            }

            $run = $Link->prepare($sql);

            if($action != "delete"){
                if ($column == null && $val == null  || $action == "insert" ) {
                    $action == "update"? $run->bindValue(":id", $client::$id):null;
                    $run->bindValue(":user_id",   $client::$user_id);
                    $run->bindValue(":descr",     $client::$description);
                    
                }
            }
            

            try {
                $run->execute();
                echo json_encode([
                    "Message"=> $msg_success,
                    "id" => $Link->lastInsertId() ?? null
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    "Message"=> "Error with QUERY xY",
                    "ERROR" => $e->getMessage()
                ]);
                die;
            }
        }

        // public function delateClient($id){

        // }

        private function messageSend($msg, $status = 200){
            http_response_code($status);
            echo json_encode([
                "mensagem" => $msg
            ]);
        } 
    }

?>
