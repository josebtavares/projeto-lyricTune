<?php

class AlbumRequestHandler
{
    private $albumRoute;

    public function __construct($albumRoute)
    {
        $this->albumRoute = $albumRoute;
    }

    public function handleRequest($method, $uri)
    {
        if (strpos($uri, '/api/albums') === 0 || preg_match('/^\/api\/album\/(\d+)$/', $uri)) {
            $this->albumRoute->handleRequest($method, $uri);
        } else {
           // echo json_encode(['error' => 'Invalid route for Album']);
        }
    }
}
