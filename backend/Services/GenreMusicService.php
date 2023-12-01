<?php

class GenreMusicService
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO genre_music (genre_id, music_id) VALUES (:genre_id, :music_id)');
        $stmt->bindParam(':genre_id', $data['genre_id']);
        $stmt->bindParam(':music_id', $data['music_id']);

        $stmt->execute();
        return $this->getById($data['genre_id'],$data['music_id']);
    }

    public function getAll()
    {
        
        $stmt = $this->db->prepare("SELECT * FROM genre_music");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($genre_id, $music_id)
    {
        $stmt = $this->db->prepare('SELECT * FROM genre_music WHERE genre_id = :genre_id AND music_id = :music_id');
        $stmt->bindParam(':genre_id', $genre_id);
        $stmt->bindParam(':music_id', $music_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($genre_id, $music_id, $data) {
        $stmt = $this->db->prepare('UPDATE genre_music SET genre_id = :new_genre_id, music_id = :new_music_id WHERE genre_id = :genre_id AND music_id = :music_id');
        $stmt->bindParam(':genre_id', $genre_id);
        $stmt->bindParam(':music_id', $music_id);
        $stmt->bindParam(':new_genre_id', $data['genre_id']);
        $stmt->bindParam(':new_music_id', $data['music_id']);
        
        $stmt->execute();

        return $this->getById($data['genre_id'], $data['music_id']);
    }

    public function delete($genre_id, $music_id){
        
        $stmt = $this->db->prepare('DELETE FROM genre_music WHERE genre_id = :genre_id AND music_id = :music_id');
        $stmt->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);
        $stmt->bindParam(':music_id', $music_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

}