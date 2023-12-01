<?php

require_once './Controllers/ClientAlbumController.php';

class ClientAlbumRoute 
{
    private $client_albumController;
   
    public function __construct($db)
    {
        $this->client_albumController = new ClientAlbumController($db);
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/client_albums"){
            $this->client_albumController->getAll();
            return true;
        }
        elseif($method === "GET" && preg_match('/^\/api\/client_album\?client=(\d+)&album=(\d+)$/', $uri, $matches)){
            $client_id = & $matches[1];
            $album_id = $matches[2];
            $this->client_albumController->getById($client_id, $album_id);
            return true;
        }

        elseif ($method === "POST" && $uri === "/api/client_album/create") {
            $this->client_albumController->create();
            return true;
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/client_album\/update\?client=(\d+)&album=(\d+)$/', $uri, $matches)) {
            $client_id = &$matches[1];
            $album_id = $matches[2];
            $this->client_albumController->update($client_id, $album_id);
            return true;
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/client_album\/delete\?client=(\d+)&album=(\d+)$/', $uri, $matches)) {
            $clientId = &$matches[1];
            $albumId = &$matches[2];
            $this->client_albumController->delete($clientId, $albumId);
            return true;
        }
        return false;


    }

    private function sendJsonResponse($data, $statusCode = 404)
    {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
        
    }
    


}
