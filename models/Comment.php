<?php
class Comment
{
    protected $database;
    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getComments($post_id)
    {
        $sql = 'SELECT * FROM comments JOIN posts ON posts.id = comments.post_id WHERE post_id = ? ORDER BY id';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $post_id, PDO::PARAM_INT);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        $comments = $statement->fetchAll();
        return $comments;
    }
    public function createComment($name, $comment_body, $post_id)
    {
        $sql = 'INSERT INTO comments (name, body) VALUES (?, ?) WHERE post_id = ?';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $name, PDO::PARAM_STR);
            $statement->bindValue(2, $comment_body, PDO::PARAM_LOB);
            $statemnet->bindValue(3, $post_id, PDO::PARAM_INT);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        return true;
    }
}
