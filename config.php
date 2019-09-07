<?php

include __DIR__ . 'models/Post.php';
include __DIR__ . 'models/Comment.php;'

try {
    $db = new PDO("sqlite:".__DIR__."/blog.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $e->getMesssage();
}

$post = new Post($db);
$comment = new Comment($db);
