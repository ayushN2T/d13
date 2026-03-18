<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address',
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
        'searchFields' => 'title,street,city,zip,country,latitude,longitude,marker,configuration_map,info_window_content',
        'iconfile' => 'EXT:smartmaps/Resources/Public/Icons/tx_smartmaps_domain_model_address.png',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'palettes' => [
        'addressPalette' => [
            'label' => 'Address Details',
            'showitem' => 'street, zip, city, country',
        ],
        'geoPalette' => [
            'label' => 'Geolocation',
            'showitem' => 'latitude, longitude',
        ],
        'marker' => ['showitem' => 'marker, --linebreak--, image_size, image_width, image_height'],

    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;General,
                    title, --palette--;;addressPalette,configuration_map,--palette--;;geoPalette,
                --div--;Map,
                    --palette--;;marker,
                --div--;InfoWindow,
                    info_window_content, info_window_image,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                    categories,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    sys_language_uid, l10n_parent, l10n_diffsource,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden, starttime, endtime
            ',
        ],
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
                'foreign_table' => 'tx_smartmaps_domain_model_address',
                'foreign_table_where' => 'AND {#tx_smartmaps_domain_model_address}.{#pid}=###CURRENT_PID### AND {#tx_smartmaps_domain_model_address}.{#sys_language_uid} IN (-1,0)',
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
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.title',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.title.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'street' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.street',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.street.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.city',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.city.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.zip',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.zip.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'country' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.country',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.country.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'itemsProcFunc' => 'NET2TYPO\\Smartmaps\\UserFunc\\CountryDatas->getCountryOptions',
                'items' => [
                    ['pleaseChoose', ''],
                ],
                'maxitems' => 1,
                'eval' => 'required',
            ],
        ],
        'latitude' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.latitude',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.latitude.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required,double2',
                'default' => ''
            ],
        ],
        'longitude' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.longitude',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.longitude.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required,double2',
                'default' => ''
            ],
        ],
        'marker' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.marker',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.marker.description',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'configuration_map' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.configuration_map',
            'config' => [
                'type' => 'user',
                'renderType' => 'SmartMapGeocodeElement',
                'parameters' => [
                    'longitude' => 'longitude',
                    'latitude' => 'latitude',
                    'address' => 'address',
                    'street' => 'street',
                    'zip' => 'zip',
                    'city' => 'city',
                    'country' => 'country'
                ],
            ],
        ],
        'image_size' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.image_size',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.image_size.description',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'image_width' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.image_width',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.image_width.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
                'default' => 0
            ]
        ],
        'image_height' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.image_height',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.image_height.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
                'default' => 0
            ]
        ],
        'info_window_content' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.info_window_content',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.info_window_content.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'enableRichtext' => 1,
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ]
                ]
            ],
        ],
        'info_window_image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.info_window_image',
            'description' => 'LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_domain_model_address.info_window_image.description',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'minitems' => 0,
                'maxitems' => 1,
            ],
            
        ],
        'categories' => [
            'exclude' => true,
            'config' => [
                'type' => 'category',
                'maxitems' => 1
            ]
        ],
    
    ],
];
