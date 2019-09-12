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
        $statement = $this->database->prepare('SELECT * FROM comments WHERE id = ?');
        $statement->bindParam(1, $comment_id, PDO::PARAM_INT);
        $statement->execute();
        $comment = $statement->fetch();
        return $comment;
    }
    public function createComment($data)
    {
        $statement = $this->database->prepare('INSERT INTO comments (name, body) VALUES (?, ?)');
        $statement->bindParam(1, $data['name'], PDO::PARAM_STR);
        $statement->bindParam(2, $data['comment'], PDO::PARAM_LOB);
        $statement->execute();
        return $this->getComment($this->database->lastInsertId());
    }
    public function updateComment($data)
    {
        $this->getComment($data['comment_id']);
        $statement = $this->database->prepare('UPDATE comments SET body = ? WHERE id = ?');
        $statement->bindParam(1, $data['comment_id'], PDO::PARAM_INT);
        $statement->bindParam(2, $data['comment'], PDO::PARAM_LOB);
        $statement->execute();
        return $this->getComment($data['comment_id']);
    }
    public function deleteComment($comment_id)
    {
        $this->getComment($comment_id);
        $statement = $this->database->prepare('DELETE FROM comments WHERE id = ?');
        $statement->bindParam(1, $comment_id, PDO::PARAM_INT);
        $statement->execute();
        return ['message' => 'The comment was deleted.'];
    }
}
