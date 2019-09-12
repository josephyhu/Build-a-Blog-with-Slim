<?php
class Comment
{
    protected $database;
    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getComment($comment_id)
    {
        $sql = 'SELECT * FROM comments WHERE id = ?';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $comment_id, PDO::PARAM_INT);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        $comment = $statement->fetch();
        return $comment;
    }
    public function createComment($name, $comment_body)
    {
        $sql = 'INSERT INTO comments (name, body) VALUES (?, ?)';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $name, PDO::PARAM_STR);
            $statement->bindValue(2, $comment_body, PDO::PARAM_LOB);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        return true;
    }
    public function updateComment($comment_body, $comment_id)
    {
        $sql = 'UPDATE comments SET body = ? WHERE id = ?';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $comment_body, PDO::PARAM_LOB);
            $statement->bindValue(2, $comment_id, PDO::PARAM_INT);
            $statemnet->execute;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        return true;
    }
    public function deleteComment($comment_id)
    {
        $sql = 'DELETE FROM comments WHERE id = ?';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $comment_id, PDO::PARAM_INT);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        return true;
    }
}
