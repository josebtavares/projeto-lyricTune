<?php
require_once './Services/MusicService.php';
class MusicController
{

    private $musicService;

    public function __construct($db)
    {
        $this->musicService = new MusicService($db);
    }

    public function create()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Check for required fields
        if (!$requestData  || empty($requestData['name'])|| empty($requestData['runtime'])|| empty($requestData['url'])|| empty($requestData['artist_id'])) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }
    
        try {
            // Additional validation or sanitization can be added here if needed
            $createdmusic = $this->musicService->create($requestData);
            $this->sendJsonResponse($createdmusic, 201);
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $musics = $this->musicService->getAll();
            $this->sendJsonResponse($musics);
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {
            $music = $this->musicService->getById($id);
            if ($music) {
                $this->sendJsonResponse($music);
            } else {
                $this->sendJsonResponse(["error" => "Music not found"], 404);
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
            $updatedMusic= $this->musicService->update($id, $requestData);

            if ($updatedMusic) {
                $this->sendJsonResponse($updatedMusic);
            } else {
                $this->sendJsonResponse(['error' => 'Music not found'], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

   public function delete($id) {
    try {
        $isDeleted = $this->musicService->delete($id);

        if ($isDeleted) {
            $this->sendJsonResponse(['message'=> 'Music deleted successfuly']);
        } else {
            $this->sendJsonResponse(['error'=> 'Music not found'], 404);
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