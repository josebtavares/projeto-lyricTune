<?php
    class User{

        public static string $id;
        public static string $name;
        public static string $email;
        public static string $password;
        public static string $photo_url;
        public static string $birth_date;
        public static string $register_date;
        public static $token;

        public function __construct(){
            self::$id = '0';
            self::$name = '';
            self::$email = '';
            self::$password = '';
            self::$photo_url = '';
            self::$token = null;
            self::$birth_date = '';
        }
        public static function setAll($name, $email,$password){
            self::$name = $name;
            self::$email = $email;
            self::$password = $password;         
        }

        public static function setId($id){
            self::$id = $id;
        }
        public static function setName($name){
            self::$name = $name;
        }
        public static function setEmail($email){
            self::$email = $email;
        }
        public static function setPassword($password){
            self::$password = $password;
        }
        public static function setToken($token){
            self::$token = $token;
        }
        public static function setBirth($birth_date){
            self::$birth_date = $birth_date;
        }
        public static function setPhoto_url($photo_url){
            self::$photo_url = $photo_url;
        }

    }

?>
