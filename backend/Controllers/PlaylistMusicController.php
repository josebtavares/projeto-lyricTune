<?php

require_once './Services/PlaylistMusicService.php';

class PlaylistMusicController
{

    private $playlist_musicService;

    public function __construct($db)
    {
        $this->playlist_musicService = new PlaylistMusicService($db);
    }

    public function create()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Check for required fields
        if (!$requestData  || empty($requestData['playlist_id']) || empty($requestData['music_id'])) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            // Additional validation or sanitization can be added here if needed
            $createdplaylist_music = $this->playlist_musicService->create($requestData);
            $this->sendJsonResponse($createdplaylist_music, 201);
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $playlist_musics = $this->playlist_musicService->getAll();
            $this->sendJsonResponse($playlist_musics,200);
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }
    }

    public function getById($playlist_id, $music_id)
    {
        try {
            $playlist_music = $this->playlist_musicService->getById($playlist_id, $music_id);
            if ($playlist_music) {
                $this->sendJsonResponse($playlist_music,200);
            } else {
                $this->sendJsonResponse(["error" => "playlist_music not found"], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }

    }

    public function update($playlist_id, $music_id) {
        $requestData = json_decode(file_get_contents('php://input'), true);

        if (!$requestData) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            $updatedplaylist_music= $this->playlist_musicService->update($playlist_id, $music_id, $requestData);

            if ($updatedplaylist_music) {
                $this->sendJsonResponse($updatedplaylist_music,200);
            } else {
                $this->sendJsonResponse(['error' => 'playlist_music not found'], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function delete($playlistId, $musicId)
    {
        try {
            $isDeleted = $this->playlist_musicService->delete($playlistId, $musicId);

            if ($isDeleted) {
                $this->sendJsonResponse(['message' => 'playlist_music deleted successfully'],200);
            } else {
                $this->sendJsonResponse(['error' => 'playlist_music not found'], 404);
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