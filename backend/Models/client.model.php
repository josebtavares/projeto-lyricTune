<?php

    include_once("user.model.php");

    class Client extends User{

        public static string $id;
        public static string $user_id;
        public static string $description;
        
        public function __construct(){
            self::$id = '0';
            self::$name = '';
            self::$email = '';
            self::$password = '';
            self::$user_id = '0';
            self::$photo_url = '';
            self::$description = '';
            self::$photo_url = 'https://i.ibb.co/xFFfc2N/default-profile-img.jpg';
            self::$birth_date = '1000-01-01';
            self::$token = null;
        }

        public static function setAll($name, $email,$password){
            self::$name = $name;
            self::$email = $email;
            self::$password = $password;         
        }

        public static function setId($id){
            self::$id = $id;
        }
        public static function setUserId($user_id){
            self::$id = $user_id;
        }
        public static function setDescription($description){
            self::$id = $description;
        }

        public static function getAll(){
            echo json_encode([
                "id" => self::$id,
                "name" => self::$name,
                "email" => self::$email,
                "password" => self::$password,
                "birth_date" => self::$birth_date,
                "user_id" => self::$user_id,
                "token" => self::$token,
                "photo_url" => self::$photo_url,
            ]);
        }
        

    }

?>
