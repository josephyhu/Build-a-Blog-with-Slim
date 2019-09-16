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

$app->get('/delete/{slug}', function ($request, $response, $args) {
    $args['post'] = $this->post;
    $this->post->deletePost($args['slug']);
    return $response->withStatus(302)->withHeader('Location', '/');
});

$app->map(['GET', 'POST'], '/edit/{slug}', function ($request, $response, $args) {
    $args['post'] = $this->post;
    $args['item'] = $this->post->getPost($args['slug']);
    if ($request->getMethod() == 'POST') {
        $args = array_merge($args, $request->getParsedBody());
        $this->post->updatePost($args['title'], $args['date'], $args['entry'], $args['tags'], $args['slug']);
        return $response->withStatus(302)->withHeader('Location', '/');
    }
    return $this->renderer->render($response, 'edit.phtml', $args);
});

$app->map(['GET', 'POST'], '/entries/{slug}', function ($request, $response, $args) {

    // Render details view
    $args['post'] = $this->post;
    $args['comment'] = $this->comment;
    $args['item'] = $this->post->getPost($args['slug']);
    $args['comments'] = $this->comment->getComments($args['slug']);
    if ($request->getMethod() == 'POST') {
        $args = array_merge($args, $request->getParsedBody());
        $this->comment->createComment($args['name'], $args['comment_body'], $args['slug']);
    }
    return $this->renderer->render($response, 'detail.phtml', $args);
});

$app->get('/tags/{tag}', function ($request, $response, $args) {
    $args['post'] = $this->post;
    $args['items'] = $this->post->getPostsByTag($args['tag']);
    return $this->renderer->render($response, 'tags.phtml', $args);
});

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    $args['post'] = $this->post;
    return $this->renderer->render($response, 'index.phtml', $args);
});
