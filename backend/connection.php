 <?php

class Connection{
    
    public string $host;
    public string $db_name;
    public string $user;
    public string $pass;

    public function Connect() {
        $env = __DIR__ . '/.env';

        if(file_exists($env)){
            $conf = parse_ini_file($env);
            $this->host = $conf['DB_HOST'];
            $this->db_name = $conf['DB_NAME'];
            $this->user = $conf['DB_USER'];
            $this->pass = $conf['DB_PASSWORD'];
            try{
                $Link = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name ,$this->user, $this->pass);

            }catch(PDOException $e){
                echo json_encode([
                    "Message"=> "Error whith connection",
                    "Fail"=> $e->getMessage()
                ]);
                die;
            }

        }else{
            echo json_encode([
                "Message"=> " Coudn't take anything on .ENV file "
            ]);
        }

        return $Link;        
    }

}



?> 