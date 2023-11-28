<?php

class PlaylistRoute
{
    private $playlistController;
    public function __construct($playlistController)
    {
        $this->playlistController = $playlistController;
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/playlists"){
            $this->playlistController->getAll();
        }
        elseif($method === "GET" && preg_match('/^\/api\/playlist\/(\d+)$/', $uri, $matches)){
            $id = & $matches[1];
            $this->playlistController->getById($id);
        }

        elseif ($method === "POST" && $uri === "/api/playlist/create") {
            $this->playlistController->create();
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/playlist\/update\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->playlistController->update($id);
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/playlist\/delete\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->playlistController->delete($id);
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
