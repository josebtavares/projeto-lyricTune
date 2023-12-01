<?php

require_once './Services/ClientAlbumService.php';

class ClientAlbumController
{

    private $client_albumService;

    public function __construct($db)
    {
        $this->client_albumService = new ClientAlbumService($db);
    }

    public function create()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Check for required fields
        if (!$requestData  || empty($requestData['client_id']) || empty($requestData['album_id'])) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            // Additional validation or sanitization can be added here if needed
            $createdclient_album = $this->client_albumService->create($requestData);
            $this->sendJsonResponse($createdclient_album, 201);
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $client_albums = $this->client_albumService->getAll();
            $this->sendJsonResponse($client_albums,200);
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }
    }

    public function getById($client_id, $album_id)
    {
        try {
            $client_album = $this->client_albumService->getById($client_id, $album_id);
            if ($client_album) {
                $this->sendJsonResponse($client_album,200);
            } else {
                $this->sendJsonResponse(["error" => "Client_album not found"], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }

    }

    public function update($client_id, $album_id) {
        $requestData = json_decode(file_get_contents('php://input'), true);

        if (!$requestData) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            $updatedclient_album= $this->client_albumService->update($client_id, $album_id, $requestData);

            if ($updatedclient_album) {
                $this->sendJsonResponse($updatedclient_album,200);
            } else {
                $this->sendJsonResponse(['error' => 'Client_album not found'], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function delete($clientId, $albumId)
    {
        try {
            $isDeleted = $this->client_albumService->delete($clientId, $albumId);

            if ($isDeleted) {
                $this->sendJsonResponse(['message' => 'Client_album deleted successfully'],200);
            } else {
                $this->sendJsonResponse(['error' => 'Client_album not found'], 404);
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
