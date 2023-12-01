<?php

require_once './Controllers/AlbumController.php';

class AlbumRoute{
   
    private $albumController;

    public function __construct($db) {
        
        $this->albumController = new AlbumController($db);
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/albums"){
            $this->albumController->getAll();
            return true;
        }
        elseif($method === "GET" && preg_match('/^\/api\/album\/(\d+)$/', $uri, $matches)){
            $id = & $matches[1];
            $this->albumController->getById($id);
            return true;
        }

        elseif ($method === "POST" && $uri === "/api/album/create") {
            $this->albumController->create();
            return true;
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/album\/update\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->albumController->update($id);
            return true;
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/album\/delete\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->albumController->delete($id);
            return true;
        }
        return false;
    
    }

    private function sendJsonResponse($data, $statusCode = 404){
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
        
    }
    

}