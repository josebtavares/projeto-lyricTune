<?php
require_once './Controllers/GenreController.php';
class GenreRoute
{
    private $genreController;
    public function __construct($db)
    {
        $this->genreController = new GenreController($db);
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/genres"){
            $this->genreController->getAll();
            return true;
        }
        elseif($method === "GET" && preg_match('/^\/api\/genre\/(\d+)$/', $uri, $matches)){
            $id = & $matches[1];
            $this->genreController->getById($id);
            return true;
        }

        elseif ($method === "POST" && $uri === "/api/genre/create") {
            $this->genreController->create();
            return true;
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/genre\/update\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->genreController->update($id);
            return true;
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/genre\/delete\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->genreController->delete($id);
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
