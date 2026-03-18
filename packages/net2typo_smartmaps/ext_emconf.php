<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'smartmaps',
    'description' => 'smartmap integration for typo3',
    'category' => 'plugin',
    'author' => '',
    'author_email' => '',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.5.0-13.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
