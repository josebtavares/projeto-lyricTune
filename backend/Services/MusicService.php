<?php

class MusicService
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO music (name,runtime, description, composer, release_date, photo_url, lyrics, status, url, album_id, artist_id) VALUES (:name, :runtime, :description, :composer, :release_date, :photo_url, :lyrics, :status, :url, :album_id, :artist_id)');
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':runtime', $data['runtime']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':composer', $data['composer']);
        $stmt->bindParam(':release_date', $data['release_date']);
        $stmt->bindParam(':photo_url', $data['photo_url']);
        $stmt->bindParam(':lyrics', $data['lyrics']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':url', $data['url']);
        $stmt->bindParam(':album_id', $data['album_id']);
        $stmt->bindParam(':artist_id', $data['artist_id']);
        $stmt->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function getAll()
    {
        $limit = 10;
        $offset = 0;
        $stmt = $this->db->prepare("SELECT * FROM music LIMIT :offset, :limit");
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM music WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare('UPDATE music SET name = :name, runtime = :runtime, description = :description, composer = :composer, release_date = :release_date, photo_url = :photo_url, lyrics = :lyrics, status = :status, url = :url, album_id = :album_id, artist_id = :artist_id WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':runtime', $data['runtime']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':composer', $data['composer']);
        $stmt->bindParam(':release_date', $data['release_date']);
        $stmt->bindParam(':photo_url', $data['photo_url']);
        $stmt->bindParam(':lyrics', $data['lyrics']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':url', $data['url']);
        $stmt->bindParam(':album_id', $data['album_id']);
        $stmt->bindParam(':artist_id', $data['artist_id']);
        $stmt->execute();

        return $this->getById($id);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM music WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
