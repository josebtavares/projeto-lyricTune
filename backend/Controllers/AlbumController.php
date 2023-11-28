<?php

class AlbumController{

    private $albumService;

    public function __construct($albumService){
        $this->albumService = $albumService;
    }

    public function create() {
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Check for required fields
        if (!$requestData || empty($requestData['name']) || empty($requestData['runtime']) || empty($requestData['artist_id'])) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            // Additional validation or sanitization can be added here if needed
            $createdAlbum = $this->albumService->create($requestData);
            $this->sendJsonResponse($createdAlbum, 201);
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }


    public function getAll(){
        try{
            $albums = $this->albumService->getAll();
            $this->sendJsonResponse($albums);
        }
        catch(PDOException $e){
            $this->sendJsonResponse([ "error"=> "Database error: ".$e->getMessage()],500);
        }
    }

    public function getById($id){
        try{
            $album = $this->albumService->getById($id);
            if($album){
                $this->sendJsonResponse($album);
            }
            else{
                $this->sendJsonResponse(["error"=> "Album not found"],404);
            }
        }
        catch(PDOException $e){
            $this->sendJsonResponse(["error"=> "Database error: ".$e->getMessage()],    500);
        }

    }

    private function sendJsonResponse($data, $statusCode = 200){
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
    }

    public function update($id) {
        $requestData = json_decode(file_get_contents('php://input'), true);

        if (!$requestData) {
            $this->sendJsonResponse(['error' => 'Invalid request data'], 400);
            return;
        }

        try {
            $updatedAlbum = $this->albumService->update($id, $requestData);

            if ($updatedAlbum) {
                $this->sendJsonResponse($updatedAlbum);
            } else {
                $this->sendJsonResponse(['error' => 'Album not found'], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function delete($id) {
        try {
            $isDeleted = $this->albumService->delete($id);

            if ($isDeleted) {
                $this->sendJsonResponse(['message' => 'Album deleted successfully']);
            } else {
                $this->sendJsonResponse(['error' => 'Album not found'], 404);
            }
        } catch (PDOException $e) {
            $this->sendJsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }
    
}