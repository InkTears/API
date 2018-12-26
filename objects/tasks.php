<?php
class Task{

    private $conn;
    private $table_name = "task";
    public $user_id;
    public $title;
    public $description;
    public $creation_date;
    public $status;

    public function __construct($db){
        $this->conn = $db;
    }

    function create()
    {

        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                user_id=:user_id, title=:title, description=:description, status=:status";

        $state = $this->conn->prepare($query);
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $state->bindParam(":user_id", $this->user_id);
        $state->bindParam(":title", $this->title);
        $state->bindParam(":description", $this->description);
        $state->bindParam(":status", $this->status);

        if($state->execute())
        {
            return true;
        }
        return false;
    }
    function read()
    {

        $query = "SELECT
                t.user_id, t.title, t.description, t.creation_date, t.status
            FROM
                " . $this->table_name . " t
            WHERE
                t.user_id = ?
            ORDER BY
                t.creation_date ASC";

        $state = $this->conn->prepare($query);
        $state->execute();
        return $state;
    }
    function readTask()
    {
        $query = "SELECT
                t.user_id, t.title, t.description, t.creation_date, t.status
            FROM
                " . $this->table_name . " t
                WHERE
                t.title = ?";

        $state = $this->conn->prepare( $query );
        $state->bindParam(1, $this->title);
        $state->execute();
        $row = $state->fetch(PDO::FETCH_ASSOC);
        $this->user_id = $row['user_id'];
        $this->title = $row['title'];
        $this->description = $row['description'];
        $this->creation_date = $row['creation_date'];
        $this->status = $row['status'];
    }

    function update()
    {
        $query = "UPDATE
                " . $this->table_name . "
            SET
                user_id = :user_id,
                title = :title,
                description = :description,
                status = :status
            WHERE
                title = :title";

        $state = $this->conn->prepare($query);
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $state->bindParam(':user_id', $this->user_id);
        $state->bindParam(':title', $this->title);
        $state->bindParam(':description', $this->description);
        $state->bindParam(':status', $this->status);

        if($state->execute())
        {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE title = ?";

        $state = $this->conn->prepare($query);
        $this->title=htmlspecialchars(strip_tags($this->title));
        $state->bindParam(1, $this->title);

        if($state->execute())
        {
            return true;
        }

        return false;
    }
}