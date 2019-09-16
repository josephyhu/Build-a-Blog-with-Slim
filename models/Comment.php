<?php
class Comment
{
    protected $database;
    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getComments($slug)
    {
        $sql = 'SELECT * FROM comments WHERE slug = ? ORDER BY id DESC';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $slug, PDO::PARAM_STR);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        $comments = $statement->fetchAll();
        return $comments;
    }
    public function createComment($name, $comment_body, $slug)
    {
        $sql = 'INSERT INTO comments (name, body, slug) VALUES (?, ?, ?)';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $name, PDO::PARAM_STR);
            $statement->bindValue(2, $comment_body, PDO::PARAM_LOB);
            $statement->bindValue(3, $slug, PDO::PARAM_STR);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        return true;
    }
}
