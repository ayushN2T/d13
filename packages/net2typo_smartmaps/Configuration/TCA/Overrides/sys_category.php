<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$temporaryColumns = [
    'map_marker' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:sys_category.map_marker',
        'config' => [
            'type' => 'file',
            'allowed' => 'common-image-types',
            'minitems' => 0,
            'maxitems' => 1,
        ],
    ],
    'map_image_size' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:sys_category.map_image_size',
        'config' => [
            'type' => 'check',
            'default' => 0,
        ],
    ],
    'map_image_width' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:sys_category.map_image_width',
        'config' => [
            'type' => 'input',
            'eval' => 'int',
            'size' => 4,
        ],
    ],
    'map_image_height' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:sys_category.map_image_height',
        'config' => [
            'type' => 'input',
            'eval' => 'int',
            'size' => 4,
        ],
    ],
];

// Add fields to sys_category
ExtensionManagementUtility::addTCAcolumns('sys_category', $temporaryColumns);

// Create palette
ExtensionManagementUtility::addFieldsToPalette(
    'sys_category',
    'smartmaps_marker',
    'map_marker, --linebreak--, map_image_size, map_image_width, map_image_height',
    ''
);

// Add palette to all TCA types
ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    '--div--;LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:sys_category.tab.map,
    --palette--;LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:sys_category.palette.marker;smartmaps_marker'
);
