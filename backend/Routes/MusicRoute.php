<?php
require_once './Controllers/MusicController.php';
class MusicRoute
{
    private $musicController;
    public function __construct($db)
    {
        $this->musicController = new MusicController($db);
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/musics"){
            $this->musicController->getAll();
            return true;
        }
        elseif($method === "GET" && preg_match('/^\/api\/music\/(\d+)$/', $uri, $matches)){
            $id = & $matches[1];
            $this->musicController->getById($id);
            return true;
        }

        elseif ($method === "POST" && $uri === "/api/music/create") {
            $this->musicController->create();
            return true;
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/music\/update\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->musicController->update($id);
            return true;
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/music\/delete\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->musicController->delete($id);
            return true;
        }
        return false;
    }

    private function sendJsonResponse($data, $statusCode = 200)
    {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
        
    }
}
