<?php
class User{

    private $conn;
    private $table_name = "user";
    public $id;
    public $name;
    public $email;

    public function __construct($db){
        $this->conn = $db;
    }
    function create()
    {

        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, email=:email";

        $state = $this->conn->prepare($query);
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $state->bindParam(":name", $this->name);
        $state->bindParam(":email", $this->email);

        if($state->execute())
        {
            return true;
        }
        return false;
    }
    function read()
    {

        $query = "SELECT
                u.id, u.name, u.email
            FROM
                " . $this->table_name . " u
            ORDER BY
                u.id ASC";

        $state = $this->conn->prepare($query);
        $state->execute();
        return $state;
    }
    function readOne()
    {
        $query = "SELECT
                u.id, u.name, u.email
            FROM
                " . $this->table_name . " u
            WHERE
                u.id = ?";

        $state = $this->conn->prepare( $query );
        $state->bindParam(1, $this->id);
        $state->execute();
        $row = $state->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
        $this->email = $row['email'];
    }
    
    function update()
    {
        $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                email = :email
            WHERE
                id = :id";

        $state = $this->conn->prepare($query);
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $state->bindParam(':name', $this->name);
        $state->bindParam(':email', $this->email);
        $state->bindParam(':id', $this->id);

        if($state->execute())
        {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $state = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $state->bindParam(1, $this->id);

        if($state->execute())
        {
            return true;
        }

        return false;
    }
}