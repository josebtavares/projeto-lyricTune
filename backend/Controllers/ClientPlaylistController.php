<?php

require_once './Services/ClientPlaylistService.php';

class ClientPlaylistController
{

    private $client_playlistService;

    public function __construct($db)
    {
        $this->client_playlistService = new ClientPlaylistService($db);
    }

    public function create()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Check for required fields
        if (!$requestData  || empty($requestData['client_id']) || empty($requestData['playlist_id'])) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            // Additional validation or sanitization can be added here if needed
            $createdclient_playlist = $this->client_playlistService->create($requestData);
            $this->sendJsonResponse($createdclient_playlist, 201);
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $client_playlists = $this->client_playlistService->getAll();
            $this->sendJsonResponse($client_playlists,200);
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }
    }

    public function getById($client_id, $playlist_id)
    {
        try {
            $client_playlist = $this->client_playlistService->getById($client_id, $playlist_id);
            if ($client_playlist) {
                $this->sendJsonResponse($client_playlist,200);
            } else {
                $this->sendJsonResponse(["error" => "Client_playlist not found"], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }

    }

    public function update($client_id, $playlist_id) {
        $requestData = json_decode(file_get_contents('php://input'), true);

        if (!$requestData) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            $updatedclient_playlist= $this->client_playlistService->update($client_id, $playlist_id, $requestData);

            if ($updatedclient_playlist) {
                $this->sendJsonResponse($updatedclient_playlist,200);
            } else {
                $this->sendJsonResponse(['error' => 'Client_playlist not found'], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function delete($clientId, $playlistId)
    {
        try {
            $isDeleted = $this->client_playlistService->delete($clientId, $playlistId);

            if ($isDeleted) {
                $this->sendJsonResponse(['message' => 'Client_playlist deleted successfully'],200);
            } else {
                $this->sendJsonResponse(['error' => 'Client_playlist not found'], 404);
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