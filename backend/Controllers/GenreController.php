<?php
require_once './Services/GenreService.php';
class GenreController
{

    private $genreService;

    public function __construct($db)
    {
        $this->genreService = new GenreService($db);
    }

    public function create()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Check for required fields
        if (!$requestData  || empty($requestData['name'])) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            // Additional validation or sanitization can be added here if needed
            $createdgenre = $this->genreService->create($requestData);
            $this->sendJsonResponse($createdgenre, 201);
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $genre = $this->genreService->getAll();
            $this->sendJsonResponse($genre);
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {
            $genre = $this->genreService->getById($id);
            if ($genre) {
                $this->sendJsonResponse($genre);
            } else {
                $this->sendJsonResponse(["error" => "Genre not found"], 404);
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
            $updatedGenre= $this->genreService->update($id, $requestData);

            if ($updatedGenre) {
                $this->sendJsonResponse($updatedGenre);
            } else {
                $this->sendJsonResponse(['error' => 'Genre not found'], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error12: ' . $e->getMessage()], 500);
        }
    }

   public function delete($id) {
    try {
        $isDeleted = $this->genreService->delete($id);

        if ($isDeleted) {
            $this->sendJsonResponse(['message'=> 'Genre deleted successfuly']);
        } else {
            $this->sendJsonResponse(['error'=> 'Genre not found'], 404);
        }
        
    } catch (PDOException $e) {
        $this->sendJsonResponse(['error'=> 'Database error' .$e->getMessage()], 500);
    }
}


    private function sendJsonResponse($data, $statusCode = 200)
    {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
    }
}
