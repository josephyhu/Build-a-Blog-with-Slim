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
        $sql = "SELECT title, date, tags, slug FROM posts WHERE tags LIKE '%$tag%' ORDER BY date DESC";
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
    public function getPost($slug)
    {
        $sql = 'SELECT * FROM posts WHERE slug = ?';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $slug, PDO::PARAM_STR);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        $post = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $post;
    }
    public function createPost($title, $date, $entry, $tags, $slug)
    {
        $sql = 'INSERT INTO posts (title, date, body, tags, slug) VALUES (?, ?, ?, ?, ?)';
        $sql2 = 'SELECT * FROM posts WHERE slug = ?';
        try {
            $statement2 = $this->database->prepare($sql2);
            $statement2->bindValue(1, $slug, PDO::PARAM_STR);
            $statement2->execute();
            if ($statement2->fetch()) {
                echo "Error: Title alreaday exists.";
            } else {
                $statement = $this->database->prepare($sql);
                $statement->bindValue(1, $title, PDO::PARAM_STR);
                $statement->bindValue(2, $date, PDO::PARAM_STR);
                $statement->bindValue(3, $entry, PDO::PARAM_LOB);
                $statement->bindValue(4, $tags, PDO::PARAM_LOB);
                $statement->bindValue(5, $slug, PDO::PARAM_STR);
                $statement->execute();
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        return true;
    }
    public function updatePost($title, $date, $entry, $tags, $slug)
    {
        $sql = 'UPDATE posts SET title = ?, date = ?, body = ?, tags = ? WHERE slug = ?';
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $title, PDO::PARAM_STR);
            $statement->bindValue(2, $date, PDO::PARAM_STR);
            $statement->bindValue(3, $entry, PDO::PARAM_LOB);
            $statement->bindValue(4, $tags, PDO::PARAM_LOB);
            $statement->bindValue(5, $slug, PDO::PARAM_STR);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        return true;
    }
    public function deletePost($slug)
    {
        $sql = 'DELETE FROM posts WHERE slug = ?';
        $sql2 = "UPDATE sqlite_sequence SET seq = 0 WHERE name = 'posts'";
        try {
            $statement = $this->database->prepare($sql);
            $statement->bindValue(1, $slug, PDO::PARAM_STR);
            $statement->execute();
            $statement2 = $this->database->prepare($sql2);
            $statement2->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
        return true;
    }
}
