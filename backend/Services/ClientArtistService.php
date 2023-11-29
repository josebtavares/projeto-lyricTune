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
        return $this->getById($this->db->lastInsertId());
    }

    public function getAll()
    {
        
        $stmt = $this->db->prepare("SELECT * FROM client_artist");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM client_artist WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare('UPDATE client_artist SET client_id = :client_id, artist_id=:artist_id WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':client_id', $data['client_id']);
        $stmt->bindParam(':artist_id', $data['artist_id']);
        
        $stmt->execute();

        return $this->getById($id);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM client_artist WHERE client_id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function deleteByClientAndArtist($clientId, $artistId){
        
        $stmt = $this->db->prepare('DELETE FROM client_artist WHERE client_id = :client_id AND artist_id = :artist_id');
        $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
        $stmt->bindParam(':artist_id', $artistId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
