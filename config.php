<?php
include __DIR__ . '/models/Post.php';
include __DIR__ . '/models/Comment.php';

$post = new Post($this->db);
$comment = new Comment($this->db);
