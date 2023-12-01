<?php


class AlbumService{

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $stmt = $this->db->prepare('INSERT INTO album (name, photo_url, release_date, runtime, artist_id, description, description_photo_url) VALUES (:name, :photo_url, :release_date, :runtime, :artist_id, :description, :description_photo_url)');
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':photo_url', $data['photo_url']);
        $stmt->bindParam(':release_date', $data['release_date']);
        $stmt->bindParam(':runtime', $data['runtime']);
        $stmt->bindParam(':artist_id', $data['artist_id']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':description_photo_url', $data['description_photo_url']);

        $stmt->execute();

        return $this->getById($this->db->lastInsertId());
    }

    public function getAll()
    {
        $limit = 10;
        $offset = 0;
        $stmt = $this->db->prepare("SELECT * FROM album LIMIT :offset, :limit");
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id){
        $stmt = $this->db->prepare('SELECT * FROM album WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function update($id, $data) {
        $stmt = $this->db->prepare('UPDATE album SET name = :name, photo_url = :photo_url, release_date = :release_date, runtime = :runtime, artist_id = :artist_id, description = :description, description_photo_url = :description_photo_url WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':photo_url', $data['photo_url']);
        $stmt->bindParam(':release_date', $data['release_date']);
        $stmt->bindParam(':runtime', $data['runtime']);
        $stmt->bindParam(':artist_id', $data['artist_id']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':description_photo_url', $data['description_photo_url']);

        $stmt->execute();

        return $this->getById($id);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM album WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    
    


}