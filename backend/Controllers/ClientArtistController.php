<?php

require_once './Services/ClientArtistService.php';

class ClientArtistController
{

    private $client_artistService;

    public function __construct($db)
    {
        $this->client_artistService = new ClientArtistService($db);
    }

    public function create()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Check for required fields
        if (!$requestData  || empty($requestData['client_id']) || empty($requestData['artist_id'])) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            // Additional validation or sanitization can be added here if needed
            $createdclient_artist = $this->client_artistService->create($requestData);
            $this->sendJsonResponse($createdclient_artist, 201);
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $client_artists = $this->client_artistService->getAll();
            $this->sendJsonResponse($client_artists,200);
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }
    }

    public function getById($client_id, $artist_id)
    {
        try {
            $client_artist = $this->client_artistService->getById($client_id, $artist_id);
            if ($client_artist) {
                $this->sendJsonResponse($client_artist,200);
            } else {
                $this->sendJsonResponse(["error" => "Client_artist not found"], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(["error" => "Database error: " . $e->getMessage()], 500);
        }

    }

    public function update($client_id, $artist_id) {
        $requestData = json_decode(file_get_contents('php://input'), true);

        if (!$requestData) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            $updatedclient_artist= $this->client_artistService->update($client_id, $artist_id, $requestData);

            if ($updatedclient_artist) {
                $this->sendJsonResponse($updatedclient_artist,200);
            } else {
                $this->sendJsonResponse(['error' => 'Client_artist not found'], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function delete($clientId, $artistId)
    {
        try {
            $isDeleted = $this->client_artistService->delete($clientId, $artistId);

            if ($isDeleted) {
                $this->sendJsonResponse(['message' => 'Client_artist deleted successfully'],200);
            } else {
                $this->sendJsonResponse(['error' => 'Client_artist not found'], 404);
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