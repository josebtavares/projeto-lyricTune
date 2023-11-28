<?php

class AlbumRoute {
    private $albumController;
    public function __construct($albumController) {
        $this->albumController = $albumController;
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/albums"){
            $this->albumController->getAll();
        }
        elseif($method === "GET" && preg_match('/^\/api\/album\/(\d+)$/', $uri, $matches)){
            $id = & $matches[1];
            $this->albumController->getById($id);
        }

        elseif ($method === "POST" && $uri === "/api/album/create") {
            $this->albumController->create();
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/album\/update\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->albumController->update($id);
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/album\/delete\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->albumController->delete($id);
        }

        else{
            $this->sendJsonResponse(['error' => 'Invalid route'],404);
        }
    }

    private function sendJsonResponse($data, $statusCode = 200){
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
        
    }
    

}