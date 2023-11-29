<?php

class ClientAlbumRoute
{
    private $client_albumController;
    public function __construct($client_albumController)
    {
        $this->client_albumController = $client_albumController;
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/client_albums"){
            $this->client_albumController->getAll();
        }
        elseif($method === "GET" && preg_match('/^\/api\/client_album\/(\d+)$/', $uri, $matches)){
            $id = & $matches[1];
            $this->client_albumController->getById($id);
        }

        elseif ($method === "POST" && $uri === "/api/client_album/create") {
            $this->client_albumController->create();
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/client_album\/update\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->client_albumController->update($id);
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/client_album\/delete\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->client_albumController->delete($id);
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/client_album\/delete\?client=(\d+)&album=(\d+)$/', $uri, $matches)) {
            $clientId = &$matches[1];
            $albumId = &$matches[2];
            $this->client_albumController->deleteByClientAndAlbum($clientId, $albumId);
        }

        else{
            echo json_encode(['error' => 'Invalid route']);
            // $this->sendJsonResponse(['error' => 'Invalid route'],404);
        }
    }

    private function sendJsonResponse($data, $statusCode = 200)
    {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
        
    }

}
