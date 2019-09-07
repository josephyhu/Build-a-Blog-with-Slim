<?php
// Routes

$app->post('/new', function ($request, $response, $args) {
    return $this->view->render($response, 'new.phtml', $args);
});

$app->post('/edit', function ($request, $response, $args) {
    return $this->view->render($response, 'edit.phtml', $args);
});

$app->get('/entries', function ($request, $response, $args) {

    // Render details view
    return $this->renderer->render($response, 'detail.phtml', $args);
});

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
