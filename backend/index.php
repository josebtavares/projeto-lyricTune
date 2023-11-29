<?php

//Album
require_once './Services/AlbumService.php';
require_once './Controllers/AlbumController.php';
require_once './Routes/AlbumRoute.php';

//Playlist
require_once './Services/PlaylistService.php';
require_once './Controllers/PlaylistController.php';
require_once './Routes/PlaylistRoute.php';

//Admin
require_once './Services/AdminService.php';
require_once './Controllers/AdminController.php';
require_once './Routes/AdminRoute.php';

//Client_Album
require_once './Services/ClientAlbumService.php';
require_once './Controllers/ClientAlbumController.php';
require_once './Routes/ClientAlbumRoute.php';

//Client_Artist
require_once './Services/ClientArtistService.php';
require_once './Controllers/ClientArtistController.php';
require_once './Routes/ClientArtistRoute.php';




//Database Configuration
$host = 'localhost';
$dbname = 'lyricTune';
$username = 'root';
$password = 'jomabata';

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

// Admin
$adminService = new adminService($db);
$adminController = new adminController($adminService);
$adminRoute = new adminRoute($adminController);

// Client_Album
$client_albumService = new ClientAlbumService($db);
$client_albumController = new clientAlbumController($client_albumService);
$client_albumRoute = new ClientAlbumRoute($client_albumController);

// Client_Artist
$client_artistService = new ClientArtistService($db);
$client_artistController = new clientArtistController($client_artistService);
$client_artistRoute = new ClientArtistRoute($client_artistController);

// Use the appropriate request handler
if (stripos($uri, '/api/album') !== false) {
    $albumRoute->handleRequest($method, $uri);
}

// Use the appropriate request handler
else if (stripos($uri, '/api/playlist') !== false) {
    $playlistRoute->handleRequest($method, $uri);
}
// Use the appropriate request handler
else if (stripos($uri, '/api/admin') !== false) {
    $adminRoute->handleRequest($method, $uri);
}
// Use the appropriate request handler
else if (stripos($uri, '/api/client_album') !== false) {
    $client_albumRoute->handleRequest($method, $uri);
}
// Use the appropriate request handler
else if (stripos($uri, '/api/client_artist') !== false) {
    $client_artistRoute->handleRequest($method, $uri);
}

else{
    echo json_encode(['error' => 'Invalid route']);
}




