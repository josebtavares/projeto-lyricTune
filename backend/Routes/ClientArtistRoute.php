<?php

class ClientArtistRoute
{
    private $client_artistController;
    public function __construct($client_artistController)
    {
        $this->client_artistController = $client_artistController;
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/client_artists"){
            $this->client_artistController->getAll();
        }
        elseif($method === "GET" && preg_match('/^\/api\/client_artist\/(\d+)$/', $uri, $matches)){
            $id = & $matches[1];
            $this->client_artistController->getById($id);
        }

        elseif ($method === "POST" && $uri === "/api/client_artist/create") {
            $this->client_artistController->create();
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/client_artist\/update\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->client_artistController->update($id);
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/client_artist\/delete\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->client_artistController->delete($id);
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/client_artist\/delete\?client=(\d+)&artist=(\d+)$/', $uri, $matches)) {
            $clientId = &$matches[1];
            $artistId = &$matches[2];
            $this->client_artistController->deleteByClientAndArtist($clientId, $artistId);
        }
        

        else{
            echo json_encode(['error' => 'Invalid routeee4']);
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
