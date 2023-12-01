<?php

require_once './Controllers/ClientArtistController.php';

class ClientArtistRoute 
{
    private $client_artistController;
   
    public function __construct($db)
    {
        $this->client_artistController = new ClientArtistController($db);
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/client_artists"){
            $this->client_artistController->getAll();
            return true;
        }
        elseif($method === "GET" && preg_match('/^\/api\/client_artist\?client=(\d+)&artist=(\d+)$/', $uri, $matches)){
            $client_id = & $matches[1];
            $artist_id = $matches[2];
            $this->client_artistController->getById($client_id, $artist_id);
            return true;
        }

        elseif ($method === "POST" && $uri === "/api/client_artist/create") {
            $this->client_artistController->create();
            return true;
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/client_artist\/update\?client=(\d+)&artist=(\d+)$/', $uri, $matches)) {
            $client_id = &$matches[1];
            $artist_id = $matches[2];
            $this->client_artistController->update($client_id, $artist_id);
            return true;
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/client_artist\/delete\?client=(\d+)&artist=(\d+)$/', $uri, $matches)) {
            $clientId = &$matches[1];
            $artistId = &$matches[2];
            $this->client_artistController->delete($clientId, $artistId);
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
