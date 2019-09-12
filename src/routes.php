<?php
// Routes

$app->get('/new', function ($request, $response, $args) {
    $args['post'] = $this->post;
    return $this->view->render($response, 'new.phtml', $args);
});

$app->get('/delete/{id}', function ($request, $response, $args) {
    $args['post'] = $this->post;
    return $this->view->render($response, 'delete.phtml', $args);
});

$app->get('/edit/{id}', function ($request, $response, $args) {
    $args['post'] = $this->post;
    return $this->view->render($response, 'edit.phtml', $args);
});

$app->get('/entries/{title}', function ($request, $response, $args) {

    // Render details view
    $args['post'] = $this->post;
    return $this->renderer->render($response, 'detail.phtml', $args);
});

$app->get('/tags/{tag}', function ($request, $response, $args) {
    $args['post'] = $this->post;
    return $this->renderer->render($response, 'tags.phtml', $args);
});

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    $args['post'] = $this->post;
    return $this->renderer->render($response, 'index.phtml', $args);
});
