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
        $statement = $this->database->prepare(
            'SELECT * FROM posts ORDER BY date DESC'
        );
        $statement->execute();
        $posts = $statement->fetchAll();
        return $posts;
    }
    public function getPost($post_id)
    {
        $statement = $this->database->prepare(
            'SELECT * FROM posts WHERE id = ?'
        );
        $statement->bindParam(1, $post_id, PDO::PARAM_INT);
        $statement->execute();
        $post = $statement->fetch();
        return $post;
    }
    public function createPost($data)
    {
        $statement = $this->database->prepare(
            'INSERT INTO posts(title, date, body, tags) VALUES(?, ?, ?, ?)'
        );
        $statement->bindParam(1, $data['title'], PDO::PARAM_STR);
        $statement->bindParam(2, $data['date'], PDO::PARAM_STR);
        $statement->bindParam(3, $data['entry'], PDO::PARAM_LOB);
        $statement->bindParam(4, $data['tags'], PDO::PARAM_LOB);
        $statement->execute();
        return $this->getPost($this->database->lastInsertId());
    }
    public function updatePost($data)
    {
        $statement = $this->database->prepare(
            'UPDATE courses SET title = ? date = ?, body = ?, tags = ? WHERE id = ?'
        );
        $statement->bindParam(1, $data['title'], PDO::PARAM_STR);
        $statement->bindParam(2, $data['date'], PDO::PARAM_STR);
        $statement->bindParam(3, $data['entry'], PDO::PARAM_LOB);
        $statement->bindParam(4, $data['tags'], PDO::PARAM_LOB);
        $statement->bindParam(5, $data['post_id'], PDO::PARAM_INT);
        $statement->execute();
        return $this->getPost($data['post_id']);
    }
    public function deletePost($post_id)
    {
        $this->getPost($post_id);
        $statement = $this->database->prepare(
            'DELETE FROM posts WHERE id = ?'
        );
        $statement->bindParam(1, $post_id, PDO::PARAM_INT);
        $statement->execute();
        return ['message' => 'The post was deleted'];
    }
}
