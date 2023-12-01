<?php

require_once './Controllers/ClientPlaylistController.php';

class ClientPlaylistRoute 
{
    private $client_playlistController;
   
    public function __construct($db)
    {
        $this->client_playlistController = new ClientPlaylistController($db);
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/client_playlists"){
            $this->client_playlistController->getAll();
            return true;
        }
        elseif($method === "GET" && preg_match('/^\/api\/client_playlist\?client=(\d+)&playlist=(\d+)$/', $uri, $matches)){
            $client_id = & $matches[1];
            $playlist_id = $matches[2];
            $this->client_playlistController->getById($client_id, $playlist_id);
            return true;
        }

        elseif ($method === "POST" && $uri === "/api/client_playlist/create") {
            $this->client_playlistController->create();
            return true;
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/client_playlist\/update\?client=(\d+)&playlist=(\d+)$/', $uri, $matches)) {
            $client_id = &$matches[1];
            $playlist_id = $matches[2];
            $this->client_playlistController->update($client_id, $playlist_id);
            return true;
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/client_playlist\/delete\?client=(\d+)&playlist=(\d+)$/', $uri, $matches)) {
            $clientId = &$matches[1];
            $playlistId = &$matches[2];
            $this->client_playlistController->delete($clientId, $playlistId);
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
