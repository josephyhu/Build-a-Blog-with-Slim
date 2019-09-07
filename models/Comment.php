<?php
namespace App\Model;
use \App\Exception\ApiException;

class Comment
{
    protected $database;
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }
    public function getCommentsByPostId($post_id)
    {
        if (empty($post_id)) {
            throw new ApiException(ApiException::COMMENT_INFO_REQUIRED);
        }
        $statement = $this->database->prepare('SELECT * FROM comments WHERE post_id=:post_id');
        $statement->bindParam('post_id', $post_id);
        $statement->execute();
        $comments = $statement->fetchAll();
        if (empty($comments)) {
            throw new ApiException(ApiException::COMMENT_NOT_FOUND, 404);
        }
        return $comments;
    }
    public function getComment($comment_id)
    {
        if (empty($comment_id)) {
            throw new ApiException(ApiException::COMMENT_INFO_REQUIRED);
        }
        $statement = $this->database->prepare('SELECT * FROM comments WHERE id=:id');
        $statement->bindParam('id', $comment_id);
        $statement->execute();
        $comment = $statement->fetch();
        if (empty($comment)) {
            throw new ApiException(ApiException::COMMENT_NOT_FOUND, 404);
        }
        return $comment;
    }
    public function createComment($data)
    {
        if (empty($data['post_id']) || empty($data['comment'])) {
            throw new ApiException(ApiException::COMMENT_INFO_REQUIRED);
        }
        $statement = $this->database->prepare('INSERT INTO comments (post_id, comment) VALUES (:post_id, :comment)');
        $statement->bindParam('post_id', $data['post_id']);
        $statement->bindParam('comment', $data['comment']);
        $statement->execute();
        if ($statement->rowCount()<1) {
            throw new ApiException(ApiException::COMMENT_CREATION_FAILED);
        }
        return $this->getComment($this->database->lastInsertId());
    }
    public function updateComment($data)
    {
        $this->getComment($data['comment_id']);
        $statement = $this->database->prepare('UPDATE comments SET comment=:comment WHERE id=:id');
        $statement->bindParam('id', $data['comment_id']);
        $statement->bindParam('comment', $data['comment']);
        $statement->execute();
        if ($statement->rowCount()<1) {\
            throw new ApiException(ApiException::COMMENT_UPDATE_FAILED);
        }
        return $this->getComment($data['comment_id']);
    }
    public function deleteReview($comment_id)
    {
        $this->getComment($comment_id);
        $statement = $this->database->prepare('DELETE FROM comments WHERE id=:id');
        $statement->bindParam('id', $comment_id);
        $statement->execute();
        if ($statement->rowCount()<1) {
            throw new ApiException(ApiException::COMMENT_DELETE_FAILED);
        }
        return ['message' => 'The comment was deleted.'];
    }
}
