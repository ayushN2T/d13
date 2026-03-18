<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,width,height',
        'iconfile' => 'EXT:smartmaps/Resources/Public/Icons/tx_smartmaps_domain_model_map.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                 --palette--;;basic, 
                --palette--;;dimensions, 
                address, 
                --div--;MapSettings,default_type,
                --palette--;;zoom, 
                --palette--;;coordinates, 
                --palette--;;cluster,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, 
                sys_language_uid, l10n_parent, l10n_diffsource, 
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, 
                hidden, starttime, endtime
            ',
        ],
    ],
    'palettes' => [
        'basic' => [
            'showitem' => 'title ,defaultmarker',
        ],
        'dimensions' => [
            'showitem' => 'width, height',
            'label' => 'Map Size'
        ],
        'cluster' => [
            'showitem' => 'marker_cluster, --linebreak--, marker_cluster_zoom, marker_cluster_size',
            'label' => 'Cluster settings'
        ],
        'zoom' => ['showitem' => 'zoom, --linebreak--, zoom_min, zoom_max', 'label'=> 'Zoom settings'],
        'coordinates' => ['showitem' => 'latitude, longitude', 'label' => 'Default map center'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_smartmaps_domain_model_map',
                'foreign_table_where' => 'AND {#tx_smartmaps_domain_model_map}.{#pid}=###CURRENT_PID### AND {#tx_smartmaps_domain_model_map}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.title',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.title.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'width' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.width',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.width.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'height' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.height',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.height.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'zoom' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.zoom',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.zoom.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'trim,int,required',
            ]
        ],
        'zoom_min' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.zoom_min',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.zoom_min.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'trim,int,required',
            ]
        ],
        'zoom_max' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.zoom_max',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.zoom_max.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'trim,int,required',
            ]
        ],
        'default_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.default_type',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.default_type.description',
            'config' => [
                'type' => 'radio',
                'items' => [
                    [
                        'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.display.default.0',
                        0
                    ],
                    [
                        'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.display.default.1',
                        1
                    ],
                    [
                        'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.display.default.2',
                        2
                    ],
                    [
                        'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.display.default.3',
                        3
                    ],
                    [
                        'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.display.default.4',
                        4
                    ],
                ],
                'eval' => '',
                'default' => 0
            ],
        ],
        'longitude' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.longitude',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.longitude.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,double2,required'
            ]
        ],
        'latitude' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.latitude',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.latitude.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,double2,required'
            ]
        ],
        'marker_cluster' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.marker_cluster',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.marker_cluster.description',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'marker_cluster_zoom' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.marker_cluster_zoom',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.marker_cluster_zoom.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
            ]
        ],
        'marker_cluster_size' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.marker_cluster_size',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.marker_cluster_size.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
            ]
        ],
        'defaultmarker' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.defaultmarker',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.defaultmarker.description',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.address',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_map.address.description',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_smartmaps_domain_model_address',
                'foreign_table' => 'tx_smartmaps_domain_model_address',
                'MM' => 'tx_smartmaps_domain_model_address_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                ],
            ]

        ],
    
    ],
];
