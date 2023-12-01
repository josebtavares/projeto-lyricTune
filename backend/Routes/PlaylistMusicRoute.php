<?php

require_once './Controllers/PlaylistMusicController.php';

class PlaylistMusictRoute 
{
    private $playlist_musicController;
   
    public function __construct($db)
    {
        $this->playlist_musicController = new PlaylistMusicController($db);
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/playlist_musics"){
            $this->playlist_musicController->getAll();
            return true;
        }
        elseif($method === "GET" && preg_match('/^\/api\/playlist_music\?playlist=(\d+)&music=(\d+)$/', $uri, $matches)){
            $playlist_id = & $matches[1];
            $music_id = $matches[2];
            $this->playlist_musicController->getById($playlist_id, $music_id);
            return true;
        }

        elseif ($method === "POST" && $uri === "/api/playlist_music/create") {
            $this->playlist_musicController->create();
            return true;
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/playlist_music\/update\?playlist=(\d+)&music=(\d+)$/', $uri, $matches)) {
            $playlist_id = &$matches[1];
            $music_id = $matches[2];
            $this->playlist_musicController->update($playlist_id, $music_id);
            return true;
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/playlist_music\/delete\?playlist=(\d+)&music=(\d+)$/', $uri, $matches)) {
            $playlistId = &$matches[1];
            $musicId = &$matches[2];
            $this->playlist_musicController->delete($playlistId, $musicId);
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
