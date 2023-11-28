<?php

class PlaylistRequestHandler
{
    private $playlistRoute;

    public function __construct($playlistRoute)
    {
        $this->playlistRoute = $playlistRoute;
    }

    public function handleRequest($method, $uri)
    {
        if (strpos($uri, '/api/playlists') === 0 || preg_match('/^\/api\/playlist\/(\d+)$/', $uri)) {
            $this->playlistRoute->handleRequest($method, $uri);
        } else {
           // echo json_encode(['error' => 'Invalid route for Playlist']);
        }
    }
}
