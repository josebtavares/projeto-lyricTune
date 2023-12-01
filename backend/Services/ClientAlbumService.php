<?php

class ClientAlbumService
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO client_album (client_id, album_id) VALUES (:client_id, :album_id)');
        $stmt->bindParam(':client_id', $data['client_id']);
        $stmt->bindParam(':album_id', $data['album_id']);

        $stmt->execute();
        return $this->getById($data['client_id'],$data['album_id']);
    }

    public function getAll()
    {
        
        $stmt = $this->db->prepare("SELECT * FROM client_album");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($client_id, $album_id)
    {
        $stmt = $this->db->prepare('SELECT * FROM client_album WHERE client_id = :client_id AND album_id = :album_id');
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':album_id', $album_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($client_id, $album_id, $data) {
        $stmt = $this->db->prepare('UPDATE client_album SET client_id = :new_client_id, album_id = :new_album_id WHERE client_id = :client_id AND album_id = :album_id');
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':album_id', $album_id);
        $stmt->bindParam(':new_client_id', $data['client_id']);
        $stmt->bindParam(':new_album_id', $data['album_id']);
        
        $stmt->execute();

        return $this->getById($data['client_id'], $data['album_id']);
    }

    public function delete($client_id, $album_id){
        
        $stmt = $this->db->prepare('DELETE FROM client_album WHERE client_id = :client_id AND album_id = :artist_id');
        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmt->bindParam(':artist_id', $album_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
    

}
