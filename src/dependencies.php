<?php

include '../models/Post.php';
include '../models/Comment.php';
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

$container['db'] = function ($c) {
    try {
        $db = new PDO("sqlite:".__DIR__."/blog.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return $db;
};

$container['post'] = function ($c) {
    $post = new Post($c->get('db'));
    return $post;
};

$container['comment'] = function ($c) {
    $comment = new Comment($c->get('db'));
    return $comment;
};
