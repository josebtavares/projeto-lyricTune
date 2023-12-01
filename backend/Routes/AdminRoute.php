<?php

require_once './Controllers/AdminController.php';

class AdminRoute
{
    private $adminController;
    
    public function __construct($db)
    {
        $this->adminController = new AdminController($db);
    }

    public function handleRequest($method, $uri){
        if($method === "GET" && $uri === "/api/admins"){
            $this->adminController->getAll();
            return true;
        }
        elseif($method === "GET" && preg_match('/^\/api\/admin\/(\d+)$/', $uri, $matches)){
            $id = & $matches[1];
            $this->adminController->getById($id);
            return true;
        }

        elseif ($method === "POST" && $uri === "/api/admin/create") {
            $this->adminController->create();
            return true;
        }

        elseif ($method === "PUT" && preg_match('/^\/api\/admin\/update\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->adminController->update($id);
            return true;
        }

        elseif ($method === "DELETE" && preg_match('/^\/api\/admin\/delete\/(\d+)$/', $uri, $matches)) {
            $id = &$matches[1];
            $this->adminController->delete($id);
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
