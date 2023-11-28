<?php

class PlaylistService
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO playlist (name, client_id, photo_url) VALUES (:name, :client_id, :photo_url)');
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':client_id', $data['client_id']);
        $stmt->bindParam(':photo_url', $data['photo_url']);
        $stmt->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function getAll()
    {
        $limit = 10;
        $offset = 0;
        $stmt = $this->db->prepare("SELECT * FROM playlist LIMIT :offset, :limit");
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM playlist WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare('UPDATE playlist SET name = :name, client_id=:client_id,photo_url = :photo_url WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':client_id', $data['client_id']);
        $stmt->bindParam(':photo_url', $data['photo_url']);
        $stmt->execute();

        return $this->getById($id);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM playlist WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
