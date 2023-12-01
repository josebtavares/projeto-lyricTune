<?php

//Album
require_once './Routes/AlbumRoute.php';
//Playlist
require_once './Routes/PlaylistRoute.php';
//Admin
require_once './Routes/AdminRoute.php';
//Client_Album
require_once './Routes/ClientAlbumRoute.php';
//Client_Artist
require_once './Routes/ClientArtistRoute.php';
//Client_Playlist
require_once './Routes/ClientPlaylistRoute.php';
//Playlist_Music
require_once './Routes/PlaylistMusicRoute.php';


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
$albumRoute = new AlbumRoute($db);
// Playlist
$playlistRoute = new PlaylistRoute($db);
// Admin
$adminRoute = new adminRoute($db);
// Client_Album
$client_albumRoute = new ClientAlbumRoute($db);
// Client_Artist
$client_artistRoute = new ClientArtistRoute($db);
// Client_Playlist
$client_playlistRoute = new ClientPlaylistRoute($db);
// Playlist_Music
$playlist_musicRoute = new PlaylistMusictRoute($db);





// Routes
if($albumRoute->handleRequest($method, $uri)) return;
if($playlistRoute->handleRequest($method, $uri)) return;
if($adminRoute->handleRequest($method, $uri)) return;
if($client_albumRoute->handleRequest($method, $uri)) return;
if($client_artistRoute->handleRequest($method, $uri)) return;
if($client_playlistRoute->handleRequest($method, $uri)) return;
if($playlist_musicRoute->handleRequest($method, $uri)) return;

// Handle invalid routes with a 404 status code
sendJsonResponse(['error' => 'Not Found'], 404);

function sendJsonResponse($data, $statusCode = 404)
{
    header("Content-Type: application/json");
    http_response_code($statusCode);
    echo json_encode($data);
    
    
}




