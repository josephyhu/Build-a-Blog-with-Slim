<?php
// Routes

$app->map(['GET', 'POST'], '/new', function ($request, $response, $args) {
    $args['post'] = $this->post;
    if ($request->getMethod() == 'POST') {
        $args = array_merge($args, $request->getParsedBody());
        $args['slug'] = implode('-', explode(' ', $args['title']));
        $this->post->createPost($args['title'], $args['date'], $args['entry'], $args['tags'], $args['slug']);
        return $response->withStatus(302)->withHeader('Location', '/');
    }
    return $this->renderer->render($response, 'new.phtml', $args);
});

$app->get('/delete/{id}', function ($request, $response, $args) {
    $args['post'] = $this->post;
    $this->post->deletePost($args['id']);
    return $response->withStatus(302)->withHeader('Location', '/');
});

$app->map(['GET', 'POST'], '/edit', function ($request, $response, $args) {
    $args['post'] = $this->post;
    if ($request->getMethod() == 'POST') {
        $args = array_merge($args, $request->getParsedBody());
        $this->post->updatePost($args['title'], $args['date'], $args['entry'], $args['tags'], $args['post_id']);
        return $response->withStatus(302)->withHeader('Location', '/');
    }
    return $this->renderer->render($response, 'edit.phtml', $args);
});

$app->get('/entries/{title}', function ($request, $response, $args) {

    // Render details view
    $args['post'] = $this->post;
    $args['comment'] = $this->comment;
    return $this->renderer->render($response, 'detail.phtml', $args);
});

$app->get('/tags', function ($request, $response, $args) {
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
