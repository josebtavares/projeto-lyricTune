<?php

class ClientArtistService
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO client_artist (client_id, artist_id) VALUES (:client_id, :artist_id)');
        $stmt->bindParam(':client_id', $data['client_id']);
        $stmt->bindParam(':artist_id', $data['artist_id']);

        $stmt->execute();
        return $this->getById($data['client_id'],$data['artist_id']);
    }

    public function getAll()
    {
        
        $stmt = $this->db->prepare("SELECT * FROM client_artist");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($client_id, $artist_id)
    {
        $stmt = $this->db->prepare('SELECT * FROM client_artist WHERE client_id = :client_id AND artist_id = :artist_id');
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':artist_id', $artist_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($client_id, $artist_id, $data) {
        $stmt = $this->db->prepare('UPDATE client_artist SET client_id = :new_client_id, artist_id = :new_artist_id WHERE client_id = :client_id AND artist_id = :artist_id');
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':artist_id', $artist_id);
        $stmt->bindParam(':new_client_id', $data['client_id']);
        $stmt->bindParam(':new_artist_id', $data['artist_id']);
        
        $stmt->execute();

        return $this->getById($data['client_id'], $data['artist_id']);
    }

    public function delete($client_id, $artist_id){
        
        $stmt = $this->db->prepare('DELETE FROM client_artist WHERE client_id = :client_id AND artist_id = :artist_id');
        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmt->bindParam(':artist_id', $artist_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
    

}