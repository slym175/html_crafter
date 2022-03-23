<?php
return [
    'versions' => '1.0.0',
    'styles' => [
        'bootstrap' => [
            'src' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css',
            'deps' => [],
            'position' => 'header',
        ]
    ],
    'scripts' => [
        'jquery' => [
            'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js',
            'deps' => [],
            'position' => 'footer',
        ],
        'bootstrap' => [
            'src' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js',
            'deps' => [],
            'position' => 'footer',
        ]
    ],
    'fonts' => [
        'tahoma' => 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap'
    ]
];