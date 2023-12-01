<?php

class PlaylistMusicService
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO playlist_music (playlist_id, music_id) VALUES (:playlist_id, :music_id)');
        $stmt->bindParam(':playlist_id', $data['playlist_id']);
        $stmt->bindParam(':music_id', $data['music_id']);

        $stmt->execute();
        return $this->getById($data['playlist_id'],$data['music_id']);
    }

    public function getAll()
    {
        
        $stmt = $this->db->prepare("SELECT * FROM playlist_music");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($playlist_id, $music_id)
    {
        $stmt = $this->db->prepare('SELECT * FROM playlist_music WHERE playlist_id = :playlist_id AND music_id = :music_id');
        $stmt->bindParam(':playlist_id', $playlist_id);
        $stmt->bindParam(':music_id', $music_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($playlist_id, $music_id, $data) {
        $stmt = $this->db->prepare('UPDATE playlist_music SET playlist_id = :new_playlist_id, music_id = :new_music_id WHERE playlist_id = :playlist_id AND music_id = :music_id');
        $stmt->bindParam(':playlist_id', $playlist_id);
        $stmt->bindParam(':music_id', $music_id);
        $stmt->bindParam(':new_playlist_id', $data['playlist_id']);
        $stmt->bindParam(':new_music_id', $data['music_id']);
        
        $stmt->execute();

        return $this->getById($data['playlist_id'], $data['music_id']);
    }

    public function delete($playlist_id, $music_id){
        
        $stmt = $this->db->prepare('DELETE FROM playlist_music WHERE playlist_id = :playlist_id AND music_id = :music_id');
        $stmt->bindParam(':playlist_id', $playlist_id, PDO::PARAM_INT);
        $stmt->bindParam(':music_id', $music_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
    

}