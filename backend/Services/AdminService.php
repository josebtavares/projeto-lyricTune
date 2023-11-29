<?php


class AdminService{

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $stmt = $this->db->prepare('INSERT INTO admin (user_id) VALUES (:user_id)');
        $stmt->bindParam(':user_id', $data['user_id']);
        
        $stmt->execute();

        return $this->getById($this->db->lastInsertId());
    }

    public function getAll()
    {
        $limit = 10;
        $offset = 0;
        $stmt = $this->db->prepare("SELECT * FROM admin LIMIT :offset, :limit");
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id){
        $stmt = $this->db->prepare('SELECT * FROM admin WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function update($id, $data) {
        $stmt = $this->db->prepare('UPDATE admin SET user_id = :user_id WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $data['user_id']);

        $stmt->execute();

        return $this->getById($id);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM admin WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }


}