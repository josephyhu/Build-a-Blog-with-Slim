<?php
return [
    'settings' => [
        'displayErrorDetails' => false,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],

        'db' => [
            'dbname' => 'blog',
        ],
    ],
];
