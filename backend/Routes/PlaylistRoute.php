<?php

require_once './Controllers/PlaylistController.php';

class PlaylistRoute 
{
    private $playlistController;
   
    public function __construct($db)
    {
        $this->playlistController = new PlaylistController($db);
    }

    public function handleRequest($method, $uri){
        
        if($method === "GET" && $uri === "/api/playlists"){
            $this->playlistController->getAll();
            return true;
        }
        elseif($method === "GET" && preg_match('/^\/api\/playlist\/(\d+)$/', $uri, $matches)){
            $id = & $matches[1];
            $this->playlistController->getById($id);
            return true;
        }

        elseif ($method === "POST" && $uri === "/api/playlist/create") {
            $this->playlistController->create();
            return true;
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/playlist\/update\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->playlistController->update($id);
            return true;
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/playlist\/delete\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->playlistController->delete($id);
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
