<?php
namespace App\Model;
use App\Exception\ApiException;

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
            'SELECT * FROM posts ORDER BY id'
        );
        $statement->execute();
        $posts = $statement->fetchAll();
        if (empty($posts)) {
            throw new ApiException(ApiException::POST_NOT_FOUND, 404);
        }
        return $posts;
    }
    public function getPost($post_id)
    {
        $statement = $this->database->prepare(
            'SELECT * FROM posts WHERE id=:id'
        );
        $statement->bindParam('id', $post_id);
        $statement->execute();
        $post = $statement->fetch();
        if (empty($posts)) {
            throw new ApiException(ApiException::POST_NOT_FOUND, 404);
        }
        return $post;
    }
    public function createPost($data)
    {
        if (empty($data['title']) || empty($data['date']) || empty($data['entry'])) {
            throw new ApiException(ApiException::POST_INFO_REQUIRED);
        }
        $statement = $this->database->prepare(
            'INSERT INTO posts(title, date, body, tags) VALUES(:title, :date, :body, :tags)'
        );
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('date', $data['date']);
        $statement->bindParam('body', $data['entry']);
        $statement->bindParam('tags', $data['tags']);
        $statement->execute();
        if ($statement->rowCount()<1) {
            throw new ApiException(ApiException::POST_CREATION_FAILED);
        }
        return $this->getPost($this->database->lastInsertId());
    }
    public function updatePost($data)
    {
        if (empty($data['post_id']) || empty($data['title']) || empty($data['date']) || empty($data['entry'])) {
            throw new ApiException(ApiException::POST_INFO_REQUIRED);
        }
        $statement = $this->database->prepare(
            'UPDATE courses SET title=:title, date=:date, body=:body, tags=:tags WHERE id=:id'
        );
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('date', $data['date']);
        $statement->bindParam('body', $data['entry']);
        $statement->bindParam('tags', $data['tags']);
        $statement->bindParam('id', $data['post_id']);
        $statement->execute();
        if ($statement->rowCount()<1) {
            throw new ApiException(ApiException::POST_UPDATE_FAILED);
        }
        return $this->getPost($data['post_id']);
    }
    public function deletePost($post_id)
    {
        $this->getPost($post_id);
        $statement = $this->database->prepare(
            'DELETE FROM posts WHERE id=:id'
        );
        $statement->bindParam('id', $post_id);
        $statement->execute();
        if ($statement->rowCount()<1) {
            throw new ApiException(ApiException::POST_DELETE_FAILED);
        }
        return ['message' => 'The post was deleted'];
    }
}
