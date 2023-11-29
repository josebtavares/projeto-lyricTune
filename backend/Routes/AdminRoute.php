<?php

class AdminRoute
{
    private $adminController;
    public function __construct($adminController)
    {
        $this->adminController = $adminController;
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/admins"){
            $this->adminController->getAll();
        }
        elseif($method === "GET" && preg_match('/^\/api\/admin\/(\d+)$/', $uri, $matches)){
            $id = & $matches[1];
            $this->adminController->getById($id);
        }

        elseif ($method === "POST" && $uri === "/api/admin/create") {
            $this->adminController->create();
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/admin\/update\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->adminController->update($id);
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/admin\/delete\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->adminController->delete($id);
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
