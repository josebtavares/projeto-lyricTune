<?php

class ClientPlaylistService
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO client_playlist (client_id, playlist_id) VALUES (:client_id, :playlist_id)');
        $stmt->bindParam(':client_id', $data['client_id']);
        $stmt->bindParam(':playlist_id', $data['playlist_id']);

        $stmt->execute();
        return $this->getById($data['client_id'],$data['playlist_id']);
    }

    public function getAll()
    {
        
        $stmt = $this->db->prepare("SELECT * FROM client_playlist");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($client_id, $playlist_id)
    {
        $stmt = $this->db->prepare('SELECT * FROM client_playlist WHERE client_id = :client_id AND playlist_id = :playlist_id');
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':playlist_id', $playlist_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($client_id, $playlist_id, $data) {
        $stmt = $this->db->prepare('UPDATE client_playlist SET client_id = :new_client_id, playlist_id = :new_playlist_id WHERE client_id = :client_id AND playlist_id = :playlist_id');
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':playlist_id', $playlist_id);
        $stmt->bindParam(':new_client_id', $data['client_id']);
        $stmt->bindParam(':new_playlist_id', $data['playlist_id']);
        
        $stmt->execute();

        return $this->getById($data['client_id'], $data['playlist_id']);
    }

    public function delete($client_id, $playlist_id){
        
        $stmt = $this->db->prepare('DELETE FROM client_playlist WHERE client_id = :client_id AND playlist_id = :playlist_id');
        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmt->bindParam(':playlist_id', $playlist_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
    

}