<?php

class ClientAlbumController
{

    private $client_albumService;

    public function __construct($client_albumService)
    {
        $this->client_albumService = $client_albumService;
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
            $this->sendJsonResponse($client_albums);
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {
            $client_album = $this->client_albumService->getById($id);
            if ($client_album) {
                $this->sendJsonResponse($client_album);
            } else {
                $this->sendJsonResponse(["error" => "Client_album not found"], 404);
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
            $updatedclient_album= $this->client_albumService->update($id, $requestData);

            if ($updatedclient_album) {
                $this->sendJsonResponse($updatedclient_album);
            } else {
                $this->sendJsonResponse(['error' => 'Client_album not found'], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

   public function delete($id) {
        try {
            $isDeleted = $this->client_albumService->delete($id);

            if ($isDeleted) {
                $this->sendJsonResponse(['message'=> 'Client_album deleted successfuly']);
            } else {
                $this->sendJsonResponse(['error'=> 'Client_album not found'], 404);
            }
            
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error'=> 'Database error' .$e->getMessage()], 500);
        }
    
    }

    public function deleteByClientAndAlbum($clientId, $albumId)
    {
        try {
            $isDeleted = $this->client_albumService->deleteByClientAndAlbum($clientId, $albumId);

            if ($isDeleted) {
                $this->sendJsonResponse(['message' => 'Client_album deleted successfully']);
            } else {
                $this->sendJsonResponse(['error' => 'Client_album not found'], 404);
            }

        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error' . $e->getMessage()], 500);
        }
    }


    private function sendJsonResponse($data, $statusCode = 200)
    {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
    }
}
