<?php

class PlaylistController
{

    private $playlistService;

    public function __construct($playlistService)
    {
        $this->playlistService = $playlistService;
    }

    public function create()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Check for required fields
        if (!$requestData  || empty($requestData['client_id'])) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            // Additional validation or sanitization can be added here if needed
            $createdplaylist = $this->playlistService->create($requestData);
            $this->sendJsonResponse($createdplaylist, 201);
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $playlists = $this->playlistService->getAll();
            $this->sendJsonResponse($playlists);
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {
            $playlist = $this->playlistService->getById($id);
            if ($playlist) {
                $this->sendJsonResponse($playlist);
            } else {
                $this->sendJsonResponse(["error" => "Playlist not found"], 404);
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
            $updatedPlaylist= $this->playlistService->update($id, $requestData);

            if ($updatedPlaylist) {
                $this->sendJsonResponse($updatedPlaylist);
            } else {
                $this->sendJsonResponse(['error' => 'Playlist not found'], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

   public function delete($id) {
    try {
        $isDeleted = $this->playlistService->delete($id);

        if ($isDeleted) {
            $this->sendJsonResponse(['message'=> 'Playlist deleted successfuly']);
        } else {
            $this->sendJsonResponse(['error'=> 'Playlist not found'], 404);
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
