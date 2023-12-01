<?php

require_once './Controllers/genremusicController.php';

class GenreMusicRoute 
{
    private $genre_musicController;
   
    public function __construct($db)
    {
        $this->genre_musicController = new GenreMsicController($db);
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/genre_musics"){
            $this->genre_musicController->getAll();
            return true;
        }
        elseif($method === "GET" && preg_match('/^\/api\/genre_music\?genre=(\d+)&music=(\d+)$/', $uri, $matches)){
            $genre_id = & $matches[1];
            $music_id = $matches[2];
            $this->genre_musicController->getById($genre_id, $music_id);
            return true;
        }

        elseif ($method === "POST" && $uri === "/api/genre_music/create") {
            $this->genre_musicController->create();
            return true;
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/genre_music\/update\?genre=(\d+)&music=(\d+)$/', $uri, $matches)) {
            $genre_id = &$matches[1];
            $music_id = $matches[2];
            $this->genre_musicController->update($genre_id, $music_id);
            return true;
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/genre_music\/delete\?genre=(\d+)&music=(\d+)$/', $uri, $matches)) {
            $genreId = &$matches[1];
            $musicId = &$matches[2];
            $this->genre_musicController->delete($genreId, $musicId);
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
