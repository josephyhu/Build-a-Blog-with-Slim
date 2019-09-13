<?php
class Post
{
    protected $database;
    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getPosts()
    {
        $sql = 'SELECT * FROM posts ORDER BY date DESC';
        try {
            $statement = $this->database->prepare($sql);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return array();
        }
        $posts = $statement->fetchAll();
        return $posts;
    }
    public function getPostsByTag($tag) {
        $sql = "SELECT id, title, date FROM posts WHERE tags LIKE '%$tag%' ORDER BY date DESC";
        try {
            $statement = $this->database->prepare($sql);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return array();
        }
        $posts = $statement->fetchAll();
        return $posts;
    }
    public function getPost($post_id)
    {
        $sql = 'SELECT * FROM posts WHERE id = ?';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $post_id, PDO::PARAM_INT);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        $post = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $post;
    }
    public function createPost($title, $date, $entry, $tags)
    {
        $sql = 'INSERT INTO posts (title, date, body, tags) VALUES (?, ?, ?, ?)';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $title, PDO::PARAM_STR);
            $statement->bindValue(2, $date, PDO::PARAM_STR);
            $statement->bindValue(3, $entry, PDO::PARAM_LOB);
            $statement->bindValue(4, $tags, PDO::PARAM_LOB);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        return true;
    }
    public function updatePost($title, $date, $entry, $tags, $post_id)
    {
        $sql = 'UPDATE posts SET title = ?, date = ?, body = ?, tags = ? WHERE id = ?';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $title, PDO::PARAM_STR);
            $statement->bindValue(2, $date, PDO::PARAM_STR);
            $statement->bindValue(3, $entry, PDO::PARAM_LOB);
            $statement->bindValue(4, $tags, PDO::PARAM_LOB);
            $statement->bindValue(5, $post_id, PDO::PARAM_INT);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        return true;
    }
    public function deletePost($post_id)
    {
        $sql = 'DELETE FROM posts WHERE id = ?';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $post_id, PDO::PARAM_INT);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        return true;
    }
}
