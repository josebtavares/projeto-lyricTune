<?php

require_once './Services/GenreMusicService.php';

class GenreMsicController
{

    private $genre_musicService;

    public function __construct($db)
    {
        $this->genre_musicService = new GenreMusicService($db);
    }

    public function create()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Check for required fields
        if (!$requestData  || empty($requestData['genre_id']) || empty($requestData['music_id'])) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            // Additional validation or sanitization can be added here if needed
            $createdgenre_music = $this->genre_musicService->create($requestData);
            $this->sendJsonResponse($createdgenre_music, 201);
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $genre_musics = $this->genre_musicService->getAll();
            $this->sendJsonResponse($genre_musics,200);
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }
    }

    public function getById($genre_id, $music_id)
    {
        try {
            $genre_music = $this->genre_musicService->getById($genre_id, $music_id);
            if ($genre_music) {
                $this->sendJsonResponse($genre_music,200);
            } else {
                $this->sendJsonResponse(["error" => "genre_music not found"], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }

    }

    public function update($genre_id, $music_id) {
        $requestData = json_decode(file_get_contents('php://input'), true);

        if (!$requestData) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            $updatedgenre_music= $this->genre_musicService->update($genre_id, $music_id, $requestData);

            if ($updatedgenre_music) {
                $this->sendJsonResponse($updatedgenre_music,200);
            } else {
                $this->sendJsonResponse(['error' => 'genre_music not found'], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function delete($genreId, $musicId)
    {
        try {
            $isDeleted = $this->genre_musicService->delete($genreId, $musicId);

            if ($isDeleted) {
                $this->sendJsonResponse(['message' => 'genre_music deleted successfully'],200);
            } else {
                $this->sendJsonResponse(['error' => 'genre_music not found'], 404);
            }

        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error' . $e->getMessage()], 500);
        }
    }


    private function sendJsonResponse($data, $statusCode = 404)
    {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
}

}
