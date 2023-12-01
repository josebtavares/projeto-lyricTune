<?php


require_once './Services/AdminService.php';

class AdminController
{

    private $adminService;

    public function __construct($db)
    {
        $this->adminService = new AdminService($db);
    }

    public function create()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Check for required fields
        if (!$requestData  || empty($requestData['user_id'])) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            // Additional validation or sanitization can be added here if needed
            $createdadmin = $this->adminService->create($requestData);
            $this->sendJsonResponse($createdadmin, 201);
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $admins = $this->adminService->getAll();
            $this->sendJsonResponse($admins,200);
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {
            $admin = $this->adminService->getById($id);
            if ($admin) {
                $this->sendJsonResponse($admin,200);
            } else {
                $this->sendJsonResponse(["error" => "Admin not found"], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }

    }

    public function update($id) {
        $requestData = json_decode(file_get_contents('php://input'), true);

        if (!$requestData) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            $updatedAdmin= $this->adminService->update($id, $requestData);

            if ($updatedAdmin) {
                $this->sendJsonResponse($updatedAdmin,200);
            } else {
                $this->sendJsonResponse(['error' => 'Admin not found'], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

   public function delete($id) {
    try {
        $isDeleted = $this->adminService->delete($id);

        if ($isDeleted) {
            $this->sendJsonResponse(['message'=> 'Admin deleted successfuly'],200);
        } else {
            $this->sendJsonResponse(['error'=> 'Admin not found'], 404);
        }
        
    } catch (PDOException $e) {
        $this->sendJsonResponse(['error'=> 'Database error' .$e->getMessage()], 500);
    }
}


    private function sendJsonResponse($data, $statusCode = 404)
    {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
    }
    
}
