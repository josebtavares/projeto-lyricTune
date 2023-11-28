<?php

//Album
require_once './Services/AlbumService.php';
require_once './Controllers/AlbumController.php';
require_once './Routes/AlbumRoute.php';

//Playlist
require_once './Services/PlaylistService.php';
require_once './Controllers/PlaylistController.php';
require_once './Routes/PlaylistRoute.php';



//Database Configuration
$host = 'localhost';
$dbname = 'lyricTune';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Album
$albumService = new AlbumService($db);
$albumController = new AlbumController($albumService);
$albumRoute = new AlbumRoute($albumController);

// Playlist
$playlistService = new PlaylistService($db);
$playlistController = new PlaylistController($playlistService);
$playlistRoute = new PlaylistRoute($playlistController);

// Use the appropriate request handler
if (stripos($uri, 'album') !== false) {
    $albumRoute->handleRequest($method, $uri);
}

// Use the appropriate request handler
else if (stripos($uri, 'playlist') !== false) {
    $playlistRoute->handleRequest($method, $uri);
}
else{
    echo json_encode(['error' => 'Invalid route']);
}




